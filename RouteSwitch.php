<?php

require_once 'controllers/RamaisController.php';
require_once 'controllers/FilasController.php';

abstract class RouteSwitch
{
    protected function home()
    {
        require __DIR__ . '/views/ramais/index.html';
    }

    protected function listarRamais()
    {
        $controller = new RamaisController();
        $controller->listAll(); 
    }

    protected function listarFilas()
    {
        $controller = new FilasController();
        $controller->listAll(); 
    }
    
    public function __call($name, $arguments)
    {
        http_response_code(404);
    }
}