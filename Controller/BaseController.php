<?php
session_start();

abstract class Controller
{
    protected $model;

    public function __construct($modelInstance)
    {
        $this->model = $modelInstance;
    }

    public function index()
    {
        return $this->model->getAll();
    }

    public function show($id)
    {
        return $this->model->getById($id);
    }

    public function destroy($id)
    {
        return $this->model->delete($id);
    }

    protected function sendJson($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    protected function checkPermission($permissionName) {
        // Les administrateurs ont tous les droits
        $currentRole = strtoupper($_SESSION['user']->role ?? '');
        if ($currentRole === 'ADMINISTRATEUR') {
            return true;
        }

        if (!isset($_SESSION['user']->permissions) || !in_array($permissionName, $_SESSION['user']->permissions)) {
            $this->sendJson(['status' => 'error', 'message' => 'Accès refusé : Permission insuffisante (' . $permissionName . ')']);
            return false;
        }
        return true;
    }
}
