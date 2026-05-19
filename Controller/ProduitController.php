<?php
require_once 'Controller/BaseController.php';
require_once 'Model/Produitdb.php';

class ProduitController extends Controller {
    public function __construct() { parent::__construct(new Produitdb()); }

    public function listWithStockAction() {
        if ($this->checkPermission('VOIR_STOCK')) {
            $this->sendJson($this->model->getAllWithStock());
        }
    }

    public function listAction() {
        if ($this->checkPermission('VOIR_PRODUIT')) {
            $this->sendJson($this->model->getAll());
        }
    }

    public function saveAction() {
        $id = !empty($_POST['id_produit']) ? $_POST['id_produit'] : null;
        $perm = $id ? 'MODIFIER_PRODUIT' : 'AJOUTER_PRODUIT';

        if ($this->checkPermission($perm)) {
            $nom = $_POST['nom'] ?? '';
            $prix_achat = $_POST['prix_achat'] ?? 0;
            $prix_vente = $_POST['prix_vente'] ?? 0;

            if ($prix_vente < $prix_achat) {
                $this->sendJson(['status' => 'error', 'message' => 'Le prix de vente ne peut pas être inférieur au prix d\'achat']);
                return;
            }
            
            $photo = $_POST['old_photo'] ?? '';

            if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
                $target_dir = "assets/img/products/";
                if (!file_exists($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }
                $file_extension = pathinfo($_FILES["photo"]["name"], PATHINFO_EXTENSION);
                $file_name = time() . '_' . uniqid() . '.' . $file_extension;
                $target_file = $target_dir . $file_name;
                
                if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
                    $photo = $file_name;
                }
            }

            $result = $this->model->save($nom, $prix_achat, $prix_vente, $photo, $id);
            $this->sendJson(['status' => $result[0] ? 'success' : 'error']);
        }
    }

    public function deleteAction() {
        if ($this->checkPermission('SUPPRIMER_PRODUIT')) {
            $id = $_POST['id_produit'] ?? null;
            $result = $this->model->delete($id);
            $this->sendJson(['status' => $result[0] ? 'success' : 'error']);
        }
    }
}
