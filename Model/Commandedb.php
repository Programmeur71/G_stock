<?php
require_once 'BaseModel.php';

class Commandedb extends Model
{
    public function __construct() { parent::__construct('commande', 'id_commande'); }

    public function save($id_user, $date, $total, $statut, $id = null) {
        if ($id === null) {
            return $this->db->requette("INSERT INTO {$this->table} (id_user, date, total, statut) VALUES (?, ?, ?, ?)", [$id_user, $date, $total, $statut]);
        }
        return $this->db->requette("UPDATE {$this->table} SET id_user=?, date=?, total=?, statut=? WHERE {$this->primaryKey}=?", [$id_user, $date, $total, $statut, $id]);
    }
}
