<?php
require_once 'Model/BaseModel.php';

class Utilisateurdb extends Model
{
    public function __construct()
    {
        parent::__construct('users', 'id_user');
    }

    public function save($nom, $prenom, $contact, $email, $password, $id_client = null, $id = null){
        if ($id === null) {
            $sql = "INSERT INTO {$this->table} (nom, prenom, contact, email, password, id_client) VALUES (?, ?, ?, ?, ?, ?)";
            return $this->db->requette($sql, [$nom, $prenom, $contact, $email, $password, $id_client]);
        } else {
            $sql = "UPDATE {$this->table} SET nom=?, prenom=?, contact=?, email=?, password=?, id_client=? WHERE {$this->primaryKey}=?";
            return $this->db->requette($sql, [$nom, $prenom, $contact, $email, $password, $id_client, $id]);
        }
    }

    public function getByEmailOrContact($username)
    {
        $sql = "SELECT * FROM {$this->table} WHERE email = ? OR contact = ?";
        $rqt = $this->db->requette($sql, [$username, $username]);
        return $this->db->recupere($rqt);
    }

    public function assignRole($id_user, $id_role)
    {
        $sql = "INSERT INTO user_role (id_user, id_role) VALUES (?, ?)";
        return $this->db->requette($sql, [$id_user, $id_role]);
    }

    public function getUserRole($id_user)
    {
        $sql = "SELECT r.designation FROM role r 
                JOIN user_role ur ON r.id_role = ur.id_role 
                WHERE ur.id_user = ?";
        $rqt = $this->db->requette($sql, [$id_user]);
        $role = $this->db->recupere($rqt);
        return $role ? $role->designation : null;
    }

    public function getUserPermissions($id_user)
    {
        $sql = "SELECT p.designation FROM permission p 
                JOIN role_permission rp ON p.id_permission = rp.id_permission 
                JOIN user_role ur ON rp.id_role = ur.id_role 
                WHERE ur.id_user = ?";
        $rqt = $this->db->requette($sql, [$id_user]);
        $perms = $this->db->recupere($rqt, false);
        $result = [];
        foreach ($perms as $p) {
            $result[] = $p->designation;
        }
        return $result;
    }

    public function syncRole($id_user, $id_role)
    {
        $this->db->requette("DELETE FROM user_role WHERE id_user = ?", [$id_user]);
        return $this->assignRole($id_user, $id_role);
    }

    public function getPersonnel()
    {
        $sql = "SELECT u.*, r.designation as role_nom, r.id_role 
                FROM {$this->table} u
                LEFT JOIN user_role ur ON u.id_user = ur.id_user
                LEFT JOIN role r ON ur.id_role = r.id_role
                WHERE u.id_client IS NULL";
        $rqt = $this->db->requette($sql);
        return $this->db->recupere($rqt, false);
    }
}
