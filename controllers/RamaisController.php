<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '../models/Model.php';

class RamaisController {
    public function index() {
        $ramaisModel = new Model('ramais');
        $ramais = $ramaisModel->all();
        echo json_encode($ramais);
    }

    public function listAll() {
        $ramaisModel = new Model('ramais');
        $ramais = $ramaisModel->all();
        echo json_encode($ramais);
    }

    public function show($id) {
        $ramaisModel = new Model('ramais');

        $ramal = $ramaisModel->find($id);

    }

    public function create() {
        $ramaisModel = new Model('ramais');

        $ramaisModel->create([
            'acl' => $_POST['acl'],
            'dyn' => $_POST['dyn'],
            'host' => $_POST['host'],
            'name' => $_POST['name'],
            'nat' => $_POST['nat'],
            'port' => $_POST['port']
        ]);

    }

    public function update($data) {
        $data = json_decode($data, true);
        $ramaisModel = new Model('filas');
        $filas = $ramaisModel->updateMultipleRamais($data);
        echo json_encode($filas);

    }

    public function delete($id) {
        $ramaisModel = new Model('ramais');

        $ramaisModel->delete($id);

    }
}
?>
