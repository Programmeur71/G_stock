<?php
require_once 'Model/BaseModel.php';

class DetailVentedb extends Model
{
    public function __construct() { parent::__construct('detail_vente', 'id_detail_vente'); }

    public function save($id_vente, $id_produit, $quantite, $prix, $id = null) {
        if ($id === null) {
            return $this->db->requette("INSERT INTO {$this->table} (id_vente, id_produit, quantite, prix) VALUES (?, ?, ?, ?)", [$id_vente, $id_produit, $quantite, $prix]);
        }
        return $this->db->requette("UPDATE {$this->table} SET id_vente=?, id_produit=?, quantite=?, prix=? WHERE {$this->primaryKey}=?", [$id_vente, $id_produit, $quantite, $prix, $id]);
    }
}
