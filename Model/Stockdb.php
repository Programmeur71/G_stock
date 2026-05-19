<?php
require_once 'Model/BaseModel.php';

class Stockdb extends Model
{
    public function __construct() { parent::__construct('stock', 'id_stock'); }

    public function getAllWithDetails()
    {
        $sql = "SELECT s.*, p.nom as produit_nom, f.nom as fournisseur_nom 
                FROM {$this->table} s
                JOIN produit p ON s.id_produit = p.id_produit
                JOIN fournisseur f ON s.id_fournisseur = f.id_fournisseur";
        $rqt = $this->db->requette($sql);
        return $this->db->recupere($rqt, false);
    }

    public function incrementOrUpdateStock($id_produit, $id_fournisseur, $quantite, $date_peremption) {
        // On cherche un lot identique (même produit, fournisseur et date de péremption)
        $sql = "SELECT id_stock, quantite FROM {$this->table} 
                WHERE id_produit = ? AND id_fournisseur = ? AND (date_peremption = ? OR (date_peremption IS NULL AND ? IS NULL))";
        $rqt = $this->db->requette($sql, [$id_produit, $id_fournisseur, $date_peremption, $date_peremption]);
        $existingStock = $this->db->recupere($rqt);

        if ($existingStock) {
            // Si le lot existe, on incrémente la quantité
            $newQty = $existingStock->quantite + $quantite;
            return $this->db->requette("UPDATE {$this->table} SET quantite = ? WHERE id_stock = ?", [$newQty, $existingStock->id_stock]);
        } else {
            // Sinon, on crée une nouvelle ligne (un nouveau lot)
            return $this->db->requette("INSERT INTO {$this->table} (id_produit, id_fournisseur, quantite, date_peremption) VALUES (?, ?, ?, ?)", [$id_produit, $id_fournisseur, $quantite, $date_peremption]);
        }
    }

    public function decrementStock($id_produit, $quantite) {
        $sql = "SELECT * FROM {$this->table} WHERE id_produit = ? AND quantite > 0 ORDER BY date_peremption ASC, id_stock ASC";
        $rqt = $this->db->requette($sql, [$id_produit]);
        $stocks = $this->db->recupere($rqt, false);

        $remaining = $quantite;
        foreach ($stocks as $stock) {
            if ($remaining <= 0) break;

            if ($stock->quantite >= $remaining) {
                $newQty = $stock->quantite - $remaining;
                $this->db->requette("UPDATE {$this->table} SET quantite = ? WHERE id_stock = ?", [$newQty, $stock->id_stock]);
                $remaining = 0;
            } else {
                $remaining -= $stock->quantite;
                $this->db->requette("UPDATE {$this->table} SET quantite = 0 WHERE id_stock = ?", [$stock->id_stock]);
            }
        }
        return $remaining === 0;
    }

    public function save($id_produit, $id_fournisseur, $quantite, $date_peremption, $id = null) {
        if ($id === null) {
            return $this->db->requette("INSERT INTO {$this->table} (id_produit, id_fournisseur, quantite, date_peremption) VALUES (?, ?, ?, ?)", [$id_produit, $id_fournisseur, $quantite, $date_peremption]);
        }
        return $this->db->requette("UPDATE {$this->table} SET id_produit=?, id_fournisseur=?, quantite=?, date_peremption=? WHERE {$this->primaryKey}=?", [$id_produit, $id_fournisseur, $quantite, $date_peremption, $id]);
    }
}
