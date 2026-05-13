<?php
require_once 'BaseModel.php';

class Produitdb extends Model
{
    public function __construct()
    {
        parent::__construct('produit', 'id_produit');
    }

    public function save($nom, $prix_achat, $prix_vente, $id = null)
    {
        if ($id === null) {
            $sql = "INSERT INTO {$this->table} (nom, prix_achat, prix_vente) VALUES (?, ?, ?)";
            return $this->db->requette($sql, [$nom, $prix_achat, $prix_vente]);
        } else {
            $sql = "UPDATE {$this->table} SET nom=?, prix_achat=?, prix_vente=? WHERE {$this->primaryKey}=?";
            return $this->db->requette($sql, [$nom, $prix_achat, $prix_vente, $id]);
        }
    }
}
