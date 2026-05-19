<?php
require_once 'Controller/BaseController.php';
require_once 'Model/Roledb.php';

require_once 'Model/RolePermissiondb.php';

class GroupeController extends Controller {
    private $rolePermissionModel;

    public function __construct() { 
        parent::__construct(new Roledb()); 
        $this->rolePermissionModel = new RolePermissiondb();
    }

    public function listAction() {
        if ($this->checkPermission('VOIR_ROLE')) {
            $this->sendJson($this->model->getAll());
        }
    }

    public function getPermissionsAction() {
        if ($this->checkPermission('VOIR_ROLE')) {
            $id_role = $_GET['id_role'] ?? null;
            if (!$id_role) $this->sendJson([]);

            $perms = $this->rolePermissionModel->getPermissionsByRole($id_role);
            $this->sendJson($perms);
        }
    }

    public function syncPermissionsAction() {
        if ($this->checkPermission('MODIFIER_ROLE')) {
            $id_role = $_POST['id_role'] ?? null;
            $permissions = json_decode($_POST['permissions'] ?? '[]', true);

            if (!$id_role) {
                $this->sendJson(['status' => 'error', 'message' => 'Rôle non identifié']);
            }

            $result = $this->rolePermissionModel->syncPermissions($id_role, $permissions);
            $this->sendJson(['status' => $result ? 'success' : 'error']);
        }
    }

    public function deleteAction() {
        if ($this->checkPermission('SUPPRIMER_ROLE')) {
            $id = $_POST['id_role'] ?? null;
            $result = $this->model->delete($id);
            $this->sendJson(['status' => $result ? 'success' : 'error']);
        }
    }

    public function saveAction() {
        $id = !empty($_POST['id_role']) ? $_POST['id_role'] : null;
        $perm = $id ? 'MODIFIER_ROLE' : 'AJOUTER_ROLE';

        if ($this->checkPermission($perm)) {
            $designation = $_POST['designation'] ?? '';
            $result = $this->model->save($designation, $id);
            $this->sendJson(['status' => $result[0] ? 'success' : 'error']);
        }
    }
}
