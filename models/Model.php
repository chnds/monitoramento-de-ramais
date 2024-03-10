<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '../db/Database.php';

$config = require_once 'config.php';


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
        try {
            new Database('filas');

           
            $query = "UPDATE FILAS SET ";

            foreach ($elemento as $extension) {

                $query .= "penalty = CASE extension ";
                foreach ($extension as $ext) {
                    $query .= "WHEN '{$ext["extension"]}' THEN {$ext["penalty"]} ";
                }
                $query .= "END, ";
                
                $query .= "status = CASE extension ";
                foreach ($extension as $ext) {
                    $query .= "WHEN '{$ext["extension"]}' THEN '{$ext["status"]}' ";
                }
                $query .= "END, ";
                
                $query .= "calls_taken = CASE extension ";
                foreach ($extension as $ext) {
                    $query .= "WHEN '{$ext["extension"]}' THEN {$ext["calls_taken"]} ";
                }
                $query .= "END, ";
                
                $query .= "name = CASE extension ";
                foreach ($extension as $ext) {
                    $query .= "WHEN '{$ext["extension"]}' THEN '{$ext["name"]}' ";
                }
                $query .= "END, ";
                
                if (isset($extension["last_call_secs_ago"])) {
                    $query .= "last_call_secs_ago = CASE extension ";
                    foreach ($extension as $ext) {
                        if (isset($ext["last_call_secs_ago"])) {
                            $query .= "WHEN '{$ext["extension"]}' THEN {$ext["last_call_secs_ago"]} ";
                        }
                    }
                    $query .= "END, ";
                }
                
                if (isset($extension["paused"])) {
                    $query .= "paused = CASE extension ";
                    foreach ($extension as $ext) {
                        if (isset($ext["paused"])) {
                            $query .= "WHEN '{$ext["extension"]}' THEN {$ext["paused"]} ";
                        }
                    }
                    $query .= "END, ";
                }
            }
            
            $query = rtrim($query, ", "); 
            $query .= " WHERE extension LIKE '%" . implode("%' OR extension LIKE '%", array_column($extension, 'extension')) . "%'";
            
            $host = Config::get('host');
            $dbname = Config::get('dbname');
            $username = Config::get('username');
            $password = Config::get('password');

            $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

            $query = trim($query); 
            $pdo->beginTransaction();
            $affectedRows = $pdo->exec($query);
            $pdo->commit();
            echo "Query executada com sucesso! Número de linhas afetadas: $affectedRows";
        } catch (PDOException $e) {
            $pdo->rollBack();
            echo "Erro ao executar a query: " . $e->getMessage();
        }
    }

    function updateMultipleRamais($elemento) {
        try {
            $query = "UPDATE RAMAIS SET ";
    
            $hostClauses = [];
            $dynClauses = [];
            $natClauses = [];
            $aclClauses = [];
            $lastCallClauses = [];
            $pausedClauses = [];
    
            foreach ($elemento as $ext) {
                $hostClauses[] = "WHEN '{$ext["name"]}' THEN '{$ext["name"]}'";
                $hostClauses[] = "WHEN '{$ext["name"]}' THEN '{$ext["host"]}'";
                $dynClauses[] = "WHEN '{$ext["name"]}' THEN '{$ext["dyn"]}'";
                $natClauses[] = "WHEN '{$ext["name"]}' THEN '{$ext["nat"]}'";
                $aclClauses[] = "WHEN '{$ext["name"]}' THEN '{$ext["acl"]}'";
                $portClauses[] = "WHEN '{$ext["name"]}' THEN '{$ext["port"]}'";
    
                if (isset($ext["last_call_secs_ago"])) {
                    $lastCallClauses[] = "WHEN '{$ext["name"]}' THEN '{$ext["last_call_secs_ago"]}'";
                }
    
                if (isset($ext["paused"])) {
                    $pausedClauses[] = "WHEN '{$ext["name"]}' THEN '{$ext["paused"]}'";
                }
            }
    
            $query .= "name = CASE name " . implode(" ", $hostClauses) . " END, ";
            $query .= "host = CASE name " . implode(" ", $hostClauses) . " END, ";
            $query .= "dyn = CASE name " . implode(" ", $dynClauses) . " END, ";
            $query .= "nat = CASE name " . implode(" ", $natClauses) . " END, ";
            $query .= "acl = CASE name " . implode(" ", $aclClauses) . " END, ";
            $query .= "port = CASE name " . implode(" ", $portClauses) . " END, ";
    
    
            $query = rtrim($query, ", ");
    
            $query .= " WHERE name IN ('" . implode("','", array_column($elemento, 'name')) . "')";
    
            $host = Config::get('host');
            $dbname = Config::get('dbname');
            $username = Config::get('username');
            $password = Config::get('password');

            $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

            $query = trim($query);

            try {
                $pdo->beginTransaction();
                $affectedRows = $pdo->exec($query);
                $pdo->commit();
                echo "Query executada com sucesso! Linhas afetadas: " . $affectedRows . "<br>";

                $stmt = $pdo->prepare("SELECT name FROM RAMAIS WHERE name IN ('7000/7000', '7001/7001', '7004/7002', '7003/7003', '7002/7004')");
                $stmt->execute();
                $updatedNames = $stmt->fetchAll(PDO::FETCH_COLUMN);
                echo "Nomes atualizados: " . implode(", ", $updatedNames);
            } catch (PDOException $e) {
                $pdo->rollBack();
                echo "Erro ao executar a query: " . $e->getMessage();
            }
        } catch (PDOException $e) {
            echo "Erro ao executar a query: " . $e->getMessage();
        }
    }
    
    

}

?>
