<?php
require_once 'Model/BaseModel.php';

class Paiementdb extends Model
{
    public function __construct() { parent::__construct('paiement', 'id_paiement'); }

    public function save($id_vente, $code, $date, $montant, $mode, $id = null) {
        if ($id === null) {
            return $this->db->requette("INSERT INTO {$this->table} (id_vente, code, date, montant, mode) VALUES (?, ?, ?, ?, ?)", [$id_vente, $code, $date, $montant, $mode]);
        }
        return $this->db->requette("UPDATE {$this->table} SET id_vente=?, code=?, date=?, montant=?, mode=? WHERE {$this->primaryKey}=?", [$id_vente, $code, $date, $montant, $mode, $id]);
    }
}
