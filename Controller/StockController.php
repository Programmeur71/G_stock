<?php
require_once 'Controller/BaseController.php';
require_once 'Model/Stockdb.php';

class StockController extends Controller {
    public function __construct() { parent::__construct(new Stockdb()); }

    public function listAction() {
        $this->sendJson($this->model->getAllWithDetails());
    }

    public function saveAction() {
        $id = $_POST['id_stock'] ?? null;
        $result = $this->model->save($_POST['id_produit'], $_POST['id_fournisseur'], $_POST['quantite'], $_POST['date_peremption'], $id);
        $this->sendJson(['status' => $result ? 'success' : 'error']);
    }

    public function deleteAction() {
        $id = $_POST['id_stock'] ?? null;
        $result = $this->model->delete($id);
        $this->sendJson(['status' => $result ? 'success' : 'error']);
    }
}
