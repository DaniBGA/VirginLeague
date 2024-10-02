<?php
require_once './app/models/fixture.model.php';
require_once './app/views/fixture.view.php';

class FixtureController {
    private $model;
    private $view;

    public function __construct() {
        $this->model = new fixtureModel();
        $this->view = new fixtureView();
    }
    
    public function mostrarTemporadas() {
        $temporadas = $this->model->getTemporadas();
        $this->view->mostrarTemporadas($temporadas);
    }
    public function mostrarFechas($temporadaId) {
        $fechas = $this->model->getFechas($temporadaId);
        $this->view->mostrarFechas($fechas);
    }
    public function showPartidosFecha($fecha) {
        $partidos = $this->model->getPartidosFecha($fecha);
        // Obtener la temporada de la primera fecha (asumiendo que hay partidos)
        $temporada = $this->model->getTemporadaPorFecha($fecha); // Asegúrate de que este método exista en tu modelo
        $this->view->showPartidosFecha($partidos, $fecha, $temporada);
    }
}
