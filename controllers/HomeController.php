<?php

class HomeController {
    public function index() {
        $viewPath = '../views/index.html';
        if (file_exists($viewPath)) {
            $content = file_get_contents($viewPath);
            echo $content;
        } else {
            header("HTTP/1.0 404 Not Found");
            echo "View não encontrada";
        }
    }
}
