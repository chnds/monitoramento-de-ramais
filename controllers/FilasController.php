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

        $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

        $ramal = $filasModel->find($id);

        echo json_encode($ramal);
    }

    public function update($data) {
        $filasModel = new Model('filas');
        $data = json_decode($data, true);
        $filas = $filasModel->updateMultipleFilas($data);
        echo json_encode($filas);
    }

    public function delete($id) {
        $filasModel = new Model('filas');

        $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

        $filasModel->delete($id);
    }
}

?>
