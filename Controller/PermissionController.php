<?php
require_once 'Controller/BaseController.php';
require_once 'Model/Permissiondb.php';

class PermissionController extends Controller {
    public function __construct() { parent::__construct(new Permissiondb()); }

    public function listAction() {
        $this->sendJson($this->model->getAll());
    }
}
