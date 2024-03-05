<?php
require_once '../config/Database.php';

class FilasModel {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
    }

    public function getAll() {
        // Método para obter todas as filas do banco de dados
    }

    public function getById($id) {
        // Método para obter uma fila específica pelo ID
    }

    public function create($data) {
        // Método para criar uma nova fila no banco de dados
    }

    public function update($id, $data) {
        // Método para atualizar os dados de uma fila no banco de dados
    }

    public function delete($id) {
        // Método para excluir uma fila do banco de dados
    }
}
?>
