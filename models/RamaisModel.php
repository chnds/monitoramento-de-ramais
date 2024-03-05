<?php
require_once '../config/Database.php';

class RamaisModel {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
    }

    public function getAll() {
        // Método para obter todos os ramais do banco de dados
    }

    public function getById($id) {
        // Método para obter um ramal específico pelo ID
    }

    public function create($data) {
        // Método para criar um novo ramal no banco de dados
    }

    public function update($id, $data) {
        // Método para atualizar os dados de um ramal no banco de dados
    }

    public function delete($id) {
        // Método para excluir um ramal do banco de dados
    }
}
?>
