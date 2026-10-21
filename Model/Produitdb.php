<?php
require_once 'Model/BaseModel.php';

class Produitdb extends Model
{
    public function __construct()
    {
        parent::__construct('produit', 'id_produit');
    }

    public function getAllWithStock()
    {
        $sql = "SELECT p.*, IFNULL(SUM(s.quantite), 0) as stock_disponible 
                FROM {$this->table} p
                LEFT JOIN stock s ON p.id_produit = s.id_produit
                GROUP BY p.id_produit";
        $rqt = $this->db->requette($sql);
        return $this->db->recupere($rqt, false);
    }

    public function save($nom, $prix_achat, $prix_vente, $photo = null, $alert = 5, $id = null)
    {
        if ($id === null) {
            $sql = "INSERT INTO {$this->table} (nom, prix_achat, prix_vente, photo, alert) VALUES (?, ?, ?, ?, ?)";
            return $this->db->requette($sql, [$nom, $prix_achat, $prix_vente, $photo, $alert]);
        } else {
            $sql = "UPDATE {$this->table} SET nom=?, prix_achat=?, prix_vente=?, photo=?, alert=? WHERE {$this->primaryKey}=?";
            return $this->db->requette($sql, [$nom, $prix_achat, $prix_vente, $photo, $alert, $id]);
        }
    }
}
