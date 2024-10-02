<?php 

class PosicionesView {
    public function mostrarTemporadas($temporadas) {
        include 'templates/posiTemp.phtml'; // Incluir la vista del fixture
    }
    public function mostrarPosiciones($posiciones) {
        include 'templates/posiciones.phtml'; // Incluir la vista del fixture
    }
    
}