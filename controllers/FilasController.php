<?php
require_once '../models/FilasModel.php';

class FilasController {
    private $filasModel;

    public function __construct() {
        $this->filasModel = new FilasModel();
    }

    public function index() {
        // Método para exibir todas as filas
    }

    public function show($id) {
        // Método para exibir uma fila específica
    }

    public function store($data) {
        // Método para armazenar uma nova fila
    }

    public function update($id, $data) {
        // Método para atualizar os dados de uma fila
    }

    public function destroy($id) {
        // Método para excluir uma fila
    }
}
?>
