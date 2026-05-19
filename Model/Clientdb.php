<?php
require_once 'Model/BaseModel.php';

class Clientdb extends Model
{
    public function __construct()
    {
        parent::__construct('client', 'id_client');
    }

    public function save($nom, $prenom, $adresse, $email, $telephone, $id = null){
        if ($id === null) {
            $sql = "INSERT INTO {$this->table} (nom, prenom, adresse, email, telephone) VALUES (?, ?, ?, ?, ?)";
            return $this->db->requette($sql, [$nom, $prenom, $adresse, $email, $telephone]);
        } else {
            $sql = "UPDATE {$this->table} SET nom=?, prenom=?, adresse=?, email=?, telephone=? WHERE {$this->primaryKey}=?";
            return $this->db->requette($sql, [$nom, $prenom, $adresse, $email, $telephone, $id]);
        }
    }
}
