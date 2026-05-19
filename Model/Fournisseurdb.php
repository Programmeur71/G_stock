<?php
require_once 'Model/BaseModel.php';

class Fournisseurdb extends Model
{
    public function __construct() { parent::__construct('fournisseur', 'id_fournisseur'); }

    public function save($nom, $prenom, $email, $adresse, $id = null) {
        if ($id === null) {
            return $this->db->requette("INSERT INTO {$this->table} (nom, prenom, email, adresse) VALUES (?, ?, ?, ?)", [$nom, $prenom, $email, $adresse]);
        }
        return $this->db->requette("UPDATE {$this->table} SET nom=?, prenom=?, email=?, adresse=? WHERE {$this->primaryKey}=?", [$nom, $prenom, $email, $adresse, $id]);
    }
}
