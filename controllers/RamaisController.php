<?php
require_once '../models/RamaisModel.php';

class RamaisController {
    private $ramaisModel;

    public function __construct() {
        $this->ramaisModel = new RamaisModel();
    }

    public function index() {
        // Método para exibir todos os ramais
    }

    public function show($id) {
        // Método para exibir um ramal específico
    }

    public function store($data) {
        // Método para armazenar um novo ramal
    }

    public function update($id, $data) {
        // Método para atualizar os dados de um ramal
    }

    public function destroy($id) {
        // Método para excluir um ramal
    }
}
?>
