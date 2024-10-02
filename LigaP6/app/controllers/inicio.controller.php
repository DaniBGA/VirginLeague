<?php
require_once './app/models/inicio.model.php';
require_once './app/views/inicio.view.php';
class inicioController {
    private $model;
    private $view;

    public function __construct() {
        $this->model = new inicioModel();
        $this->view = new inicioView();
    }

    function showInicio() {
        $this->view->showInicio();
    }
}