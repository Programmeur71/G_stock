<?php
require_once 'Controller/BaseController.php';
require_once 'Model/Ventedb.php';

require_once 'Model/DetailVentedb.php';
require_once 'Model/Stockdb.php';

class VenteController extends Controller {
    private $detailVenteModel;
    private $stockModel;

    public function __construct() { 
        parent::__construct(new Ventedb()); 
        $this->detailVenteModel = new DetailVentedb();
        $this->stockModel = new Stockdb();
    }

    public function createFromCartAction() {
        $cart = json_decode($_POST['cart'] ?? '[]', true);
        if (empty($cart)) {
            echo json_encode(['status' => 'error', 'message' => 'Le panier est vide']);
            return;
        }

        $user = $_SESSION['user'];
        $id_client = $user->id_client;
        $id_user = $user->id_user; // Le client est l'utilisateur qui fait la vente sur lui-même ici
        $date = date('Y-m-d');
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // 1. Créer la vente (En attente par défaut, SANS décrémenter le stock)
        $venteResult = $this->model->save($id_user, $id_client, $date, $total, 'En attente');
        if (!$venteResult[0]) {
            echo json_encode(['status' => 'error', 'message' => 'Erreur lors de la création de la vente']);
            return;
        }
        $id_vente = $venteResult[1];

        // 2. Créer les détails uniquement
        foreach ($cart as $item) {
            $this->detailVenteModel->save($id_vente, $item['id'], $item['quantity'], $item['price']);
        }

        echo json_encode(['status' => 'success', 'message' => 'Commande passée avec succès !']);
    }

    public function confirmDeliveryAction() {
        if ($this->checkPermission('MODIFIER_VENTE')) {
            $id_vente = $_POST['id_vente'] ?? null;
            if (!$id_vente) {
                $this->sendJson(['status' => 'error', 'message' => 'Vente non identifiée']);
            }

            $vente = $this->model->getById($id_vente);
            if (!$vente || $vente->statut === 'Livré') {
                $this->sendJson(['status' => 'error', 'message' => 'Cette vente est déjà livrée ou n\'existe pas']);
            }

            // 1. Mettre à jour le statut
            $result = $this->model->save($vente->id_user, $vente->id_client, $vente->date, $vente->total, 'Livré', $id_vente);
            
            if ($result[0]) {
                // 2. Décrémenter le stock pour chaque produit de la vente
                $details = $this->model->getDetails($id_vente);
                foreach ($details as $item) {
                    $this->stockModel->decrementStock($item->id_produit, $item->quantite);
                }
                $this->sendJson(['status' => 'success', 'message' => 'Vente confirmée et stock mis à jour']);
            } else {
                $this->sendJson(['status' => 'error', 'message' => 'Erreur lors de la confirmation']);
            }
        }
    }

    public function createAdminSaleAction() {
        if ($this->checkPermission('AJOUTER_VENTE')) {
            $id_client = $_POST['id_client'] ?? null;
            $livrer = $_POST['livrer'] === 'true';
            $panier = json_decode($_POST['panier'] ?? '[]', true);

            if (empty($panier)) {
                $this->sendJson(['status' => 'error', 'message' => 'Le panier est vide']);
            }

            if (!$id_client || empty($id_client)) {
                $this->sendJson(['status' => 'error', 'message' => 'Le choix du client est obligatoire']);
            }

            $id_user = $_SESSION['user']->id_user;
            $date = date('Y-m-d');
            $total = 0;
            foreach ($panier as $item) {
                $total += $item['prix'] * $item['quantite'];
            }

            // 1. Créer la vente
            $statut = $livrer ? 'Livré' : 'En attente';
            $venteResult = $this->model->save($id_user, $id_client, $date, $total, $statut);
            $id_vente = $venteResult[1];

            if (!$id_vente) {
                $this->sendJson(['status' => 'error', 'message' => 'Échec de l\'enregistrement de la vente']);
            }

            // 2. Créer les détails et décrémenter le stock SEULEMENT SI LIVRÉ
            foreach ($panier as $item) {
                $this->detailVenteModel->save($id_vente, $item['id_produit'], $item['quantite'], $item['prix']);
                
                if ($livrer) {
                    // Déstockage FIFO
                    $this->stockModel->decrementStock($item['id_produit'], $item['quantite']);
                }
            }

            $msg = $livrer ? 'Vente effectuée et stock décrémenté.' : 'Vente enregistrée en attente de livraison (stock inchangé).';
            $this->sendJson(['status' => 'success', 'message' => $msg]);
        }
    }

    public function listAllAction() {
        if ($this->checkPermission('VOIR_VENTE')) {
            $ventes = $this->model->getAllWithDetails();
            $this->sendJson($ventes);
        }
    }

    public function listByUserAction() {
        $user = $_SESSION['user'];
        if ($user->id_client) {
            $ventes = $this->model->getByClient($user->id_client);
            $this->sendJson($ventes);
        } else {
            $this->sendJson([]);
        }
    }

    public function getDetailsAction() {
        $id_vente = $_GET['id'] ?? null;
        if (!$id_vente) {
            $this->sendJson([]);
        }

        $user = $_SESSION['user'];
        $vente = $this->model->getById($id_vente);

        if (!$vente) {
            $this->sendJson([]);
        }

        // Si c'est un administrateur/vendeur, on vérifie la permission globale
        // Si c'est un client, on vérifie que la vente lui appartient
        // $isAdmin = $this->hasPermission('VOIR_VENTE');
        // $isOwner = ($user->id_client && $vente->id_client == $user->id_client);

         $details = $this->model->getDetails($id_vente);
         $this->sendJson($details);

        // if ($isAdmin || $isOwner) {
        //     $details = $this->model->getDetails($id_vente);
        //     $this->sendJson($details);
        // } else {
        //     $this->sendJson(['status' => 'error', 'message' => 'Accès refusé']);
        // }
    }
}
