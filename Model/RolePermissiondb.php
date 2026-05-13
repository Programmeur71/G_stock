<?php
require_once 'BaseModel.php';

class RolePermissiondb extends Model
{
    public function __construct() { parent::__construct('role_permission', 'id_role'); } // Note: table à clé composite

    public function save($id_role, $id_permission) {
        return $this->db->requette("INSERT INTO {$this->table} (id_role, id_permission) VALUES (?, ?)", [$id_role, $id_permission]);
    }
    
    public function deleteRow($id_role, $id_permission) {
        return $this->db->requette("DELETE FROM {$this->table} WHERE id_role=? AND id_permission=?", [$id_role, $id_permission]);
    }
}
