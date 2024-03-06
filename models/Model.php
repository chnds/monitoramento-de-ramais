<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '../db/Database.php';

class Model {
    protected $table;
    protected $db;

    public function __construct($table) {
        $this->table = $table;
        $this->db = new Database();
    }

    public function all() {
        return $this->db->select("SELECT * FROM {$this->table}");
    }

    public function find($id) {
        return $this->db->select("SELECT * FROM {$this->table} WHERE id = ?", [$id]);
    }

    public function create($data) {
        $columns = implode(', ', array_keys($data));
        $placeholders = rtrim(str_repeat('?, ', count($data)), ', ');
        $values = array_values($data);
        $sql = "INSERT INTO {$this->table} ($columns) VALUES ($placeholders)";
        return $this->db->insert($sql, $values);
    }

    public function update($id, $data) {
        $set = '';
        foreach ($data as $column => $value) {
            $set .= "$column = ?, ";
        }
        $set = rtrim($set, ', ');
        $values = array_values($data);
        $values[] = $id;
        $sql = "UPDATE {$this->table} SET $set WHERE id = ?";
        return $this->db->update($sql, $values);
    }

    public function delete($id) {
        $sql = "DELETE FROM {$this->table} WHERE id = ?";
        return $this->db->delete($sql, [$id]);
    }
}

?>
