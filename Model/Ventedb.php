<?php
require_once 'BaseModel.php';

class Ventedb extends Model
{
    public function __construct() { parent::__construct('vente', 'id_vente'); }

    public function save($id_user, $id_client, $date, $total, $statut, $id = null) {
        if ($id === null) {
            return $this->db->requette("INSERT INTO {$this->table} (id_user, id_client, date, total, statut) VALUES (?, ?, ?, ?, ?)", [$id_user, $id_client, $date, $total, $statut]);
        }
        return $this->db->requette("UPDATE {$this->table} SET id_user=?, id_client=?, date=?, total=?, statut=? WHERE {$this->primaryKey}=?", [$id_user, $id_client, $date, $total, $statut, $id]);
    }
}
