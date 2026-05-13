<?php
require_once 'BaseController.php';
require_once '../Model/Clientdb.php';

class ClientController extends Controller {
    public function __construct() { parent::__construct(new Clientdb()); }

    public function listAction() {
        $this->sendJson($this->model->getAll());
    }

    public function saveAction() {
        $id = $_POST['id_client'] ?? null;
        $result = $this->model->save($_POST['nom'], $_POST['prenom'], $_POST['adresse'], $_POST['email'], $_POST['telephone'], $id);
        $this->sendJson(['status' => $result ? 'success' : 'error']);
    }

    public function deleteAction() {
        $result = $this->model->delete($_POST['id_client']);
        $this->sendJson(['status' => $result ? 'success' : 'error']);
    }
}
