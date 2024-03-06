<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '../models/Model.php';

class RamaisController {
    public function index() {
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
            'numero' => $_POST['numero'],
            'nome' => $_POST['nome'],
            'ip' => $_POST['ip'],
            'status' => $_POST['status']
        ]);

    }

    public function update($id) {
        $ramaisModel = new Model('ramais');

        $ramaisModel->update($id, [
            'numero' => $_POST['numero'],
            'nome' => $_POST['nome'],
            'ip' => $_POST['ip'],
            'status' => $_POST['status']
        ]);

    }

    public function delete($id) {
        $ramaisModel = new Model('ramais');

        $ramaisModel->delete($id);

    }
}
?>
