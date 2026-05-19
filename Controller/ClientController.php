<?php
require_once 'Controller/BaseController.php';
require_once 'Model/Clientdb.php';

require_once 'Model/Utilisateurdb.php';

class ClientController extends Controller {
    private $userModel;
    public function __construct() { 
        parent::__construct(new Clientdb()); 
        $this->userModel = new Utilisateurdb();
    }

    public function listAction() {
        if ($this->checkPermission('VOIR_CLIENT')) {
            $this->sendJson($this->model->getAll());
        }
    }

    public function saveAction() {
        $id = !empty($_POST['id_client']) ? $_POST['id_client'] : null;
        $perm = $id ? 'MODIFIER_CLIENT' : 'AJOUTER_CLIENT';
        
        if ($this->checkPermission($perm)) {
            $nom = $_POST['nom'] ?? '';
            $prenom = $_POST['prenom'] ?? '';
            $adresse = $_POST['adresse'] ?? '';
            $email = $_POST['email'] ?? '';
            $telephone = $_POST['telephone'] ?? '';

            $result = $this->model->save($nom, $prenom, $adresse, $email, $telephone, $id);
            
            if ($result[0] && $id === null) {
                // ... (reste de la logique de création de compte utilisateur)
                $id_client = $result[1];
                $defaultPassword = password_hash('1234', PASSWORD_DEFAULT);
                $existingUser = $this->userModel->getByEmailOrContact($email);
                if (!$existingUser) {
                    $userResult = $this->userModel->save($nom, $prenom, $telephone, $email, $defaultPassword, $id_client);
                    if ($userResult[0]) {
                        $this->userModel->assignRole($userResult[1], 1); // Rôle CLIENTS
                    }
                }
            }
            $this->sendJson(['status' => $result[0] ? 'success' : 'error']);
        }
    }

    public function deleteAction() {
        if ($this->checkPermission('SUPPRIMER_CLIENT')) {
            $result = $this->model->delete($_POST['id_client']);
            $this->sendJson(['status' => $result[0] ? 'success' : 'error']);
        }
    }
}
