<?php
require_once 'Controller/BaseController.php';
require_once 'Model/Utilisateurdb.php';

require_once 'Model/Clientdb.php';

class UtilisateurController extends Controller {
    private $clientModel;
    public function __construct() { 
        parent::__construct(new Utilisateurdb()); 
        $this->clientModel = new Clientdb();
    }

    public function loginAction() {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        $user = $this->model->getByEmailOrContact($username);

        if ($user && password_verify($password, $user->password)) {
            $user->role = $this->model->getUserRole($user->id_user);
            // Charger les permissions
            $user->permissions = $this->model->getUserPermissions($user->id_user);
            
            $_SESSION['user'] = $user;
            
            // LOG DE DÉBOGAGE
            error_log("Utilisateur connecté: " . $user->email);
            error_log("Rôle détecté: " . $user->role);
            error_log("Nombre de permissions: " . count($user->permissions));
            
            echo json_encode(['status' => 'success', 'message' => 'Connexion réussie', 'role' => $user->role]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Identifiant ou mot de passe incorrect']);
        }
    }

    public function registerAction() {
        $nom = $_POST['name'] ?? '';
        $prenom = $_POST['firstname'] ?? '';
        $contact = $_POST['contact'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        // 1. Créer le client
        $clientResult = $this->clientModel->save($nom, $prenom, '', $email, $contact);
        if (!$clientResult[0]) {
            echo json_encode(['status' => 'error', 'message' => 'Erreur lors de la création du profil client']);
            return;
        }
        $id_client = $clientResult[1];

        // 2. Créer l'utilisateur lié au client
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $result = $this->model->save($nom, $prenom, $contact, $email, $hashedPassword, $id_client);

        if ($result[0]) {
            $id_user = $result[1];
            // 3. Assigner le rôle CLIENTS (ID 1)
            $this->model->assignRole($id_user, 1);
            echo json_encode(['status' => 'success', 'message' => 'Compte créé avec succès']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Erreur lors de la création du compte utilisateur']);
        }
    }

    public function updateProfileAction() {
        $id_user = $_POST['id_user'] ?? null;
        $nom = $_POST['nom'] ?? '';
        $prenom = $_POST['prenom'] ?? '';
        $contact = $_POST['contact'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if (!$id_user) {
            echo json_encode(['status' => 'error', 'message' => 'Utilisateur non identifié']);
            return;
        }

        $currentUser = $this->model->getById($id_user);
        $finalPassword = $currentUser->password;

        if (!empty($password)) {
            $finalPassword = password_hash($password, PASSWORD_DEFAULT);
        }

        $result = $this->model->save($nom, $prenom, $contact, $email, $finalPassword, $id_user);

        if ($result[0]) {
            // Mettre à jour la session
            $user = $this->model->getById($id_user);
            $user->role = $this->model->getUserRole($id_user);
            $_SESSION['user'] = $user;
            echo json_encode(['status' => 'success', 'message' => 'Profil mis à jour avec succès']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Erreur lors de la mise à jour']);
        }
    }

    public function listAction() {
        if ($this->checkPermission('VOIR_UTILISATEUR')) {
            // Appeler la méthode du modèle pour n'avoir que le personnel
            $users = $this->model->getPersonnel();
            $this->sendJson($users);
        }
    }

    public function deleteAction() {
        if ($this->checkPermission('SUPPRIMER_UTILISATEUR')) {
            $id = $_POST['id_user'] ?? null;
            $result = $this->model->delete($id);
            $this->sendJson(['status' => $result ? 'success' : 'error']);
        }
    }

    public function saveAction() {
        $id = !empty($_POST['id_user']) ? $_POST['id_user'] : null;
        $perm = $id ? 'MODIFIER_UTILISATEUR' : 'AJOUTER_UTILISATEUR';

        if ($this->checkPermission($perm)) {
            $id_role = $_POST['id_role'] ?? null;
            $nom = $_POST['nom'] ?? '';
            $prenom = $_POST['prenom'] ?? '';
            $contact = $_POST['contact'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $currentUser = $id ? $this->model->getById($id) : null;
            $finalPassword = $currentUser ? $currentUser->password : password_hash('123456', PASSWORD_DEFAULT);

            if (!empty($password)) {
                $finalPassword = password_hash($password, PASSWORD_DEFAULT);
            }

            $result = $this->model->save($nom, $prenom, $contact, $email, $finalPassword, null, $id);
            
            if ($result[0]) {
                $id_user = $id ? $id : $result[1];
                if ($id_role) {
                    // Utiliser la méthode du modèle (plus sécurisé)
                    $this->model->syncRole($id_user, $id_role);
                }
                $this->sendJson(['status' => 'success', 'message' => 'Utilisateur enregistré avec succès']);
            } else {
                $this->sendJson(['status' => 'error', 'message' => 'Erreur lors de l\'enregistrement en base de données']);
            }
        }
    }

    public function getUserRoleDataAction() {
        if ($this->checkPermission('VOIR_UTILISATEUR')) {
            $id_user = $_GET['id_user'] ?? null;
            $sql = "SELECT id_role FROM user_role WHERE id_user = ?";
            $rqt = $this->model->db->requette($sql, [$id_user]);
            $data = $this->model->db->recupere($rqt);
            $this->sendJson($data);
        }
    }

    public function logoutAction() {
        session_destroy();
        header("Location: login");
        exit;
    }
}
