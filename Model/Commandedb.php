<?php
require_once 'Model/BaseModel.php';

class Commandedb extends Model
{
    public function __construct() { parent::__construct('commande', 'id_commande'); }

    public function createWithDetails($id_user, $id_fournisseur, $date, $total, $panier) {
        $db = $this->db->connexiondb();
        try {
            $db->beginTransaction();

            // 1. Création de la commande
            $sql_cmd = "INSERT INTO commande (id_user, date, total, statut) VALUES (?, ?, ?, ?)";
            $stmt_cmd = $db->prepare($sql_cmd);
            $stmt_cmd->execute([$id_user, $date, $total, 'Terminée']);
            $id_commande = $db->lastInsertId();

            if (!$id_commande) throw new Exception('Impossible de générer l\'ID de commande');

            foreach ($panier as $item) {
                // 2. Création des détails
                $sql_det = "INSERT INTO detail_commande (id_commande, id_produit, quantite, prix_unitaire) VALUES (?, ?, ?, ?)";
                $stmt_det = $db->prepare($sql_det);
                $stmt_det->execute([$id_commande, $item['id_produit'], $item['quantite'], $item['prix']]);

                // 3. Gestion du stock (Incrémentation intelligente)
                $date_p = !empty($item['date_peremption']) ? $item['date_peremption'] : null;
                
                // Recherche d'un lot identique
                $sql_check = "SELECT id_stock, quantite FROM stock 
                             WHERE id_produit = ? AND id_fournisseur = ? AND (date_peremption = ? OR (date_peremption IS NULL AND ? IS NULL))";
                $stmt_check = $db->prepare($sql_check);
                $stmt_check->execute([$item['id_produit'], $id_fournisseur, $date_p, $date_p]);
                $existing = $stmt_check->fetch(PDO::FETCH_OBJ);

                if ($existing) {
                    $newQty = $existing->quantite + $item['quantite'];
                    $sql_upd = "UPDATE stock SET quantite = ? WHERE id_stock = ?";
                    $stmt_upd = $db->prepare($sql_upd);
                    $stmt_upd->execute([$newQty, $existing->id_stock]);
                } else {
                    $sql_ins = "INSERT INTO stock (id_produit, id_fournisseur, quantite, date_peremption) VALUES (?, ?, ?, ?)";
                    $stmt_ins = $db->prepare($sql_ins);
                    $stmt_ins->execute([$item['id_produit'], $id_fournisseur, $item['quantite'], $date_p]);
                }
            }

            $db->commit();
            return true;
        } catch (Exception $e) {
            $db->rollBack();
            return $e->getMessage();
        }
    }

    public function save($id_user, $date, $total, $statut, $id = null) {
        if ($id === null) {
            return $this->db->requette("INSERT INTO {$this->table} (id_user, date, total, statut) VALUES (?, ?, ?, ?)", [$id_user, $date, $total, $statut]);
        }
        return $this->db->requette("UPDATE {$this->table} SET id_user=?, date=?, total=?, statut=? WHERE {$this->primaryKey}=?", [$id_user, $date, $total, $statut, $id]);
    }

    public function getAllWithDetails() {
        $sql = "SELECT c.*, u.nom as utilisateur_nom, u.prenom as utilisateur_prenom 
                FROM {$this->table} c 
                LEFT JOIN users u ON c.id_user = u.id_user 
                ORDER BY c.date DESC";
        $rqt = $this->db->requette($sql);
        return $this->db->recupere($rqt, false);
    }

    public function getDetails($id_commande) {
        $sql = "SELECT dc.*, p.nom as produit_nom 
                FROM detail_commande dc 
                JOIN produit p ON dc.id_produit = p.id_produit 
                WHERE dc.id_commande = ?";
        $rqt = $this->db->requette($sql, [$id_commande]);
        return $this->db->recupere($rqt, false);
    }
}
