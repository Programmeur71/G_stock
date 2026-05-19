<?php
require_once 'Model/BaseModel.php';

class DetailCommandedb extends Model
{
    public function __construct() { parent::__construct('detail_commande', 'id_detail_commande'); }

    public function save($id_commande, $id_produit, $quantite, $prix_unitaire, $id = null) {
        if ($id === null) {
            return $this->db->requette("INSERT INTO {$this->table} (id_commande, id_produit, quantite, prix_unitaire) VALUES (?, ?, ?, ?)", [$id_commande, $id_produit, $quantite, $prix_unitaire]);
        }
        return $this->db->requette("UPDATE {$this->table} SET id_commande=?, id_produit=?, quantite=?, prix_unitaire=? WHERE {$this->primaryKey}=?", [$id_commande, $id_produit, $quantite, $prix_unitaire, $id]);
    }
}
