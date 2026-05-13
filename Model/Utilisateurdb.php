<?php
require_once 'BaseModel.php';

class Utilisateurdb extends Model
{
    public function __construct()
    {
        parent::__construct('users', 'id_user');
    }

    public function save($nom, $prenom, $email, $password, $id = null)
    {
        if ($id === null) {
            $sql = "INSERT INTO {$this->table} (nom, prenom, email, password) VALUES (?, ?, ?, ?)";
            return $this->db->requette($sql, [$nom, $prenom, $email, $password]);
        } else {
            $sql = "UPDATE {$this->table} SET nom=?, prenom=?, email=?, password=? WHERE {$this->primaryKey}=?";
            return $this->db->requette($sql, [$nom, $prenom, $email, $password, $id]);
        }
    }
}
