<?php
require_once 'Model/BaseModel.php';

class Ventedb extends Model
{
    public function __construct() { parent::__construct('vente', 'id_vente'); }

    public function save($id_user, $id_client, $date, $total, $statut, $id = null) {
        if ($id === null) {
            return $this->db->requette("INSERT INTO {$this->table} (id_user, id_client, date, total, statut) VALUES (?, ?, ?, ?, ?)", [$id_user, $id_client, $date, $total, $statut]);
        }
        return $this->db->requette("UPDATE {$this->table} SET id_user=?, id_client=?, date=?, total=?, statut=? WHERE {$this->primaryKey}=?", [$id_user, $id_client, $date, $total, $statut, $id]);
    }

    public function getAllWithDetails() {
        $sql = "SELECT v.*, c.nom as client_nom, c.prenom as client_prenom, u.nom as vendeur_nom 
                FROM {$this->table} v 
                LEFT JOIN client c ON v.id_client = c.id_client 
                LEFT JOIN users u ON v.id_user = u.id_user 
                ORDER BY v.date DESC";
        $rqt = $this->db->requette($sql);
        return $this->db->recupere($rqt, false);
    }

    public function getDetails($id_vente) {
        $sql = "SELECT dv.*, p.nom as produit_nom 
                FROM detail_vente dv 
                JOIN produit p ON dv.id_produit = p.id_produit 
                WHERE dv.id_vente = ?";
        $rqt = $this->db->requette($sql, [$id_vente]);
        return $this->db->recupere($rqt, false);
    }
}
