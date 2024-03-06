<?php

require_once 'controllers/RamaisController.php';

abstract class RouteSwitch
{
    protected function home()
    {
        require __DIR__ . '/views/ramais/index.html';
    }

    protected function ramais()
    {
        $controller = new RamaisController();
        $controller->index(); 
    }
    
    public function __call($name, $arguments)
    {
        http_response_code(404);
    }
}