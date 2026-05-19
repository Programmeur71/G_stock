<?php
require_once 'Controller/BaseController.php';
require_once 'Model/Commandedb.php';

require_once 'Model/DetailCommandedb.php';
require_once 'Model/Stockdb.php';

class CommandeController extends Controller {
    private $detailCommandeModel;
    private $stockModel;

    public function __construct() { 
        parent::__construct(new Commandedb()); 
        $this->detailCommandeModel = new DetailCommandedb();
        $this->stockModel = new Stockdb();
    }

    public function listAction() {
        if ($this->checkPermission('VOIR_COMMANDE')) {
            $this->sendJson($this->model->getAll());
        }
    }

    public function listWithDetailsAction() {
        if ($this->checkPermission('VOIR_COMMANDE')) {
            $commandes = $this->model->getAllWithDetails();
            $this->sendJson($commandes);
        }
    }

    public function getDetailsAction() {
        if ($this->checkPermission('VOIR_COMMANDE')) {
            $id_commande = $_GET['id'] ?? null;
            if (!$id_commande) {
                $this->sendJson([]);
            }
            
            $details = $this->model->getDetails($id_commande);
            $this->sendJson($details);
        }
    }

    public function createAndStockAction() {
        if ($this->checkPermission('AJOUTER_COMMANDE')) {
            $id_fournisseur = $_POST['id_fournisseur'] ?? null;
            $panier = json_decode($_POST['panier'] ?? '[]', true);

            if (empty($panier)) {
                $this->sendJson(['status' => 'error', 'message' => 'Le panier est vide']);
            }

            if (!$id_fournisseur) {
                $this->sendJson(['status' => 'error', 'message' => 'Fournisseur non sélectionné']);
            }

            $id_user = $_SESSION['user']->id_user;
            $date = date('Y-m-d');
            $total = 0;
            foreach ($panier as $item) {
                $total += $item['prix'] * $item['quantite'];
            }

            $result = $this->model->createWithDetails($id_user, $id_fournisseur, $date, $total, $panier);

            if ($result === true) {
                $this->sendJson(['status' => 'success', 'message' => 'Commande enregistrée avec succès et stock mis à jour !']);
            } else {
                $this->sendJson(['status' => 'error', 'message' => 'Erreur lors de l\'enregistrement : ' . $result]);
            }
        }
    }

    public function saveAction() {
        $id = !empty($_POST['id_commande']) ? $_POST['id_commande'] : null;
        $perm = $id ? 'MODIFIER_COMMANDE' : 'AJOUTER_COMMANDE';
        if ($this->checkPermission($perm)) {
            $id_user = $_POST['id_user'] ?? '';
            $date = $_POST['date'] ?? date('Y-m-d');
            $total = $_POST['total'] ?? 0;
            $statut = $_POST['statut'] ?? 'En attente';

            $result = $this->model->save($id_user, $date, $total, $statut, $id);
            $this->sendJson(['status' => $result[0] ? 'success' : 'error']);
        }
    }

    public function deleteAction() {
        if ($this->checkPermission('SUPPRIMER_COMMANDE')) {
            $id = $_POST['id_commande'] ?? null;
            $result = $this->model->delete($id);
            $this->sendJson(['status' => $result[0] ? 'success' : 'error']);
        }
    }
}
