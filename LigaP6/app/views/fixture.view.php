<?php 

class fixtureView {
    public function mostrarTemporadas($temporadas) {
        include 'templates/temporadas.phtml'; // Incluir la vista del fixture
    }
    public function mostrarFechas($fechas) {
        include 'templates/fixture.phtml'; // Incluir la vista del fixture
    }
    public function showPartidosFecha($partidos, $fecha, $temporada){
        include 'templates/content.phtml'; 
    }
}