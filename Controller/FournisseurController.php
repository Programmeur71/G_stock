<?php
require_once 'Controller/BaseController.php';
require_once 'Model/Fournisseurdb.php';

class FournisseurController extends Controller {
    public function __construct() { parent::__construct(new Fournisseurdb()); }

    public function listAction() {
        if ($this->checkPermission('VOIR_FOURNISSEUR')) {
            $this->sendJson($this->model->getAll());
        }
    }

    public function saveAction() {
        $id = !empty($_POST['id_fournisseur']) ? $_POST['id_fournisseur'] : null;
        $perm = $id ? 'MODIFIER_FOURNISSEUR' : 'AJOUTER_FOURNISSEUR';

        if ($this->checkPermission($perm)) {
            $nom = $_POST['nom'] ?? '';
            $prenom = $_POST['prenom'] ?? '';
            $email = $_POST['email'] ?? '';
            $adresse = $_POST['adresse'] ?? '';

            $result = $this->model->save($nom, $prenom, $email, $adresse, $id);
            $this->sendJson(['status' => $result[0] ? 'success' : 'error']);
        }
    }

    public function deleteAction() {
        if ($this->checkPermission('SUPPRIMER_FOURNISSEUR')) {
            $id = $_POST['id_fournisseur'] ?? null;
            $result = $this->model->delete($id);
            $this->sendJson(['status' => $result[0] ? 'success' : 'error']);
        }
    }
}
