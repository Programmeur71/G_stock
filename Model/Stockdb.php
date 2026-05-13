<?php
require_once 'BaseModel.php';

class Stockdb extends Model
{
    public function __construct() { parent::__construct('stock', 'id_stock'); }

    public function save($id_produit, $id_fournisseur, $quantite, $date_peremption, $id = null) {
        if ($id === null) {
            return $this->db->requette("INSERT INTO {$this->table} (id_produit, id_fournisseur, quantite, date_peremption) VALUES (?, ?, ?, ?)", [$id_produit, $id_fournisseur, $quantite, $date_peremption]);
        }
        return $this->db->requette("UPDATE {$this->table} SET id_produit=?, id_fournisseur=?, quantite=?, date_peremption=? WHERE {$this->primaryKey}=?", [$id_produit, $id_fournisseur, $quantite, $date_peremption, $id]);
    }
}
