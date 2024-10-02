<?php
require_once './app/models/posiciones.model.php';
require_once './app/models/fixture.model.php';
require_once './app/views/posiciones.view.php';

class PosicionesController {
    private $model;
    private $fixtureModel;
    private $equiposModel;
    private $view;

    public function __construct() {
        $this->model = new PosicionesModel();
        $this->fixturemodel = new fixtureModel();

        $this->view = new PosicionesView();
    }
    
    public function mostrarTemporadas() {
        $temporadas = $this->model->getTemporadas();
        $this->view->mostrarTemporadas($temporadas);
    }
    public function mostrarPosiciones($temporada) {
        $posiciones = $this->model->getPosiciones($temporada);
        $this->view->mostrarPosiciones($posiciones);
    }

    public function calcularPuntos() {
        $partidos = $this->fixturemodel->getPartidos();
    
        foreach($partidos as $partido){
            if ($partido->goles_local > $partido->goles_visita) {
                // Si gana el equipo local
                $this->model->actualizarPuntos($partido->equipo_local, 3, 1, 0, 0, $partido->goles_local, $partido->goles_visita);
                $this->model->actualizarPuntos($partido->equipo_visita, 0, 0, 1, 0, $partido->goles_visita, $partido->goles_local);
            } elseif ($partido->goles_local < $partido->goles_visita) {
                // Si gana el equipo visitante
                $this->model->actualizarPuntos($partido->equipo_local, 0, 0, 1, 0, $partido->goles_local, $partido->goles_visita);
                $this->model->actualizarPuntos($partido->equipo_visita, 3, 1, 0, 0, $partido->goles_visita, $partido->goles_local);
            } elseif($partido->goles_local == $partido->goles_visita && $partido->goles_local >= 0 && $partido->goles_visita >= 0) {
                // Si hay empate
                $this->model->actualizarPuntos($partido->equipo_local, 1, 0, 0, 1, $partido->goles_local, $partido->goles_visita);
                $this->model->actualizarPuntos($partido->equipo_visita, 1, 0, 0, 1, $partido->goles_visita, $partido->goles_local);
            }
        }  
    }
    public function resetearPuntos(){
        $this->model->resetearPuntos();
    }
}