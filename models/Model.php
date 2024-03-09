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

    public function joinTables($primaryTable, $secondaryTable, $joinColumn) {
        $sql = "SELECT {$secondaryTable}.* FROM {$primaryTable} JOIN {$secondaryTable} ON {$primaryTable}.{$joinColumn} = {$secondaryTable}.{$joinColumn}";
        return $this->db->select($sql);
    }
    
    function updateMultipleFilas($elemento)
    {
        $database = new Database('filas');

        if (!is_array($elemento)) {
            echo 'O elemento não é um array válido.';
            return;
        }

        $query = "UPDATE FILAS SET ";

        foreach ($elemento as $extension) {
            $query .= "penalty = CASE extension ";
            foreach ($elemento as $ext) {
                $query .= "WHEN '{$ext["extension"]}' THEN {$ext["penalty"]} ";
            }
            $query .= "END, ";
            
            $query .= "status = CASE extension ";
            foreach ($elemento as $ext) {
                $query .= "WHEN '{$ext["extension"]}' THEN '{$ext["status"]}' ";
            }
            $query .= "END, ";
            
            $query .= "calls_taken = CASE extension ";
            foreach ($elemento as $ext) {
                $query .= "WHEN '{$ext["extension"]}' THEN {$ext["calls_taken"]} ";
            }
            $query .= "END, ";
            
            $query .= "name = CASE extension ";
            foreach ($elemento as $ext) {
                $query .= "WHEN '{$ext["extension"]}' THEN '{$ext["name"]}' ";
            }
            $query .= "END, ";
            
            if (isset($extension["last_call_secs_ago"])) {
                $query .= "last_call_secs_ago = CASE extension ";
                foreach ($elemento as $ext) {
                    if (isset($ext["last_call_secs_ago"])) {
                        $query .= "WHEN '{$ext["extension"]}' THEN {$ext["last_call_secs_ago"]} ";
                    }
                }
                $query .= "END, ";
            }
            
            if (isset($extension["paused"])) {
                $query .= "paused = CASE extension ";
                foreach ($elemento as $ext) {
                    if (isset($ext["paused"])) {
                        $query .= "WHEN '{$ext["extension"]}' THEN {$ext["paused"]} ";
                    }
                }
                $query .= "END, ";
            }
        }
        
        $query = rtrim($query, ", "); 
        $query .= " WHERE extension IN ('" . implode("','", array_column($elemento, 'extension')) . "')"; 

        $pdo = new PDO("mysql:host=localhost;dbname=dev_junior", "root", "");
        $query = trim($query); 
        try {
            $pdo->beginTransaction();
            $pdo->exec($query);
            $pdo->commit();
            echo "Query executada com sucesso!";
        } catch (PDOException $e) {
            $pdo->rollBack();
            echo "Erro ao executar a query: " . $e->getMessage();
        }
    }

    function updateMultipleRamais($elemento){
        $query = "UPDATE ramais SET ";
    
        foreach ($elemento as $peer) {
            $query .= "host = CASE name ";
            $query .= "WHEN '{$peer["name"]}' THEN '{$peer["host"]}' ";
            $query .= "END, ";
            
            $query .= "dyn = CASE name ";
            $query .= "WHEN '{$peer["name"]}' THEN '{$peer["dyn"]}' ";
            $query .= "END, ";
            
            $query .= "nat = CASE name ";
            $query .= "WHEN '{$peer["name"]}' THEN '{$peer["nat"]}' ";
            $query .= "END, ";
            
            $query .= "acl = CASE name ";
            $query .= "WHEN '{$peer["name"]}' THEN '{$peer["acl"]}' ";
            $query .= "END, ";
            
            $query .= "port = CASE name ";
            $query .= "WHEN '{$peer["name"]}' THEN '{$peer["port"]}' ";
            $query .= "END, ";
        }
        
        $query = rtrim($query, ", "); // Remove a vírgula extra no final
        $query .= " WHERE name IN (";
        
        $peerNames = array_column($elemento, 'name');
        $query .= "'" . implode("','", $peerNames) . "')";
        
    }

}

?>
