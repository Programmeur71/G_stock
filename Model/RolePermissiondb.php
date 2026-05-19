<?php
require_once 'Model/BaseModel.php';

class RolePermissiondb extends Model
{
    public function __construct() { parent::__construct('role_permission', 'id_role'); } // Note: table à clé composite

    public function save($id_role, $id_permission) {
        return $this->db->requette("INSERT IGNORE INTO {$this->table} (id_role, id_permission) VALUES (?, ?)", [$id_role, $id_permission]);
    }

    public function getPermissionsByRole($id_role) {
        $sql = "SELECT id_permission FROM {$this->table} WHERE id_role = ?";
        $rqt = $this->db->requette($sql, [$id_role]);
        return $this->db->recupere($rqt, false);
    }

    public function syncPermissions($id_role, $permissions) {
        // 1. Supprimer toutes les permissions actuelles
        $this->db->requette("DELETE FROM {$this->table} WHERE id_role = ?", [$id_role]);
        
        // 2. Ajouter les nouvelles
        if (!empty($permissions)) {
            foreach ($permissions as $id_p) {
                $this->save($id_role, $id_p);
            }
        }
        return true;
    }

    public function deleteRow($id_role, $id_permission) {
        return $this->db->requette("DELETE FROM {$this->table} WHERE id_role=? AND id_permission=?", [$id_role, $id_permission]);
    }
}
