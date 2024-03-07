<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '../models/Model.php';

class FilasController {
    public function index() {
        $filasModel = new Model('filas');
        $filas = $filasModel->all();
        echo json_encode($filas);
    }

    public function listAll() {
        $filasModel = new Model('filas');
        $filas = $filasModel->joinTables('ramais','filas','id');
        echo json_encode($filas);
    }

    public function show($id) {
        $filasModel = new Model('filas');

        $ramal = $filasModel->find($id);

    }

    public function create() {
        $filasModel = new Model('filas');

        $filasModel->create([
            'numero' => $_POST['numero'],
            'nome' => $_POST['nome'],
            'ip' => $_POST['ip'],
            'status' => $_POST['status']
        ]);

    }

    public function update($id) {
        $filasModel = new Model('filas');

        $filasModel->update($id, [
            'numero' => $_POST['numero'],
            'nome' => $_POST['nome'],
            'ip' => $_POST['ip'],
            'status' => $_POST['status']
        ]);

    }

    public function delete($id) {
        $filasModel = new Model('filas');

        $filasModel->delete($id);

    }
}
?>
