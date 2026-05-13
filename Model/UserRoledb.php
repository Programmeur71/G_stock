<?php
require_once 'BaseModel.php';

class UserRoledb extends Model
{
    public function __construct() { parent::__construct('user_role', 'id_user'); } // Note: table à clé composite

    public function save($id_user, $id_role) {
        return $this->db->requette("INSERT INTO {$this->table} (id_user, id_role) VALUES (?, ?)", [$id_user, $id_role]);
    }
    
    public function deleteRow($id_user, $id_role) {
        return $this->db->requette("DELETE FROM {$this->table} WHERE id_user=? AND id_role=?", [$id_user, $id_role]);
    }
}
