<?php

require_once 'Model/Database.php';

abstract class Model
{
    protected $db;
    protected $table;
    protected $primaryKey;

    public function __construct($table, $primaryKey)
    {
        $this->db = new Database();
        $this->table = $table;
        $this->primaryKey = $primaryKey;
    }

    public function getAll()
    {
        $sql = "SELECT * FROM {$this->table}";
        $rqt = $this->db->requette($sql);
        return $this->db->recupere($rqt, false);
    }

    public function getById($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = ?";
        $rqt = $this->db->requette($sql, [$id]);
        return $this->db->recupere($rqt);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = ?";
        return $this->db->requette($sql, [$id]);
    }
}
