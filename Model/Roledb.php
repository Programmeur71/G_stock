<?php
require_once 'BaseModel.php';

class Roledb extends Model
{
    public function __construct() { parent::__construct('role', 'id_role'); }

    public function save($designation, $id = null) {
        if ($id === null) {
            return $this->db->requette("INSERT INTO {$this->table} (designation) VALUES (?)", [$designation]);
        }
        return $this->db->requette("UPDATE {$this->table} SET designation=? WHERE {$this->primaryKey}=?", [$designation, $id]);
    }
}
