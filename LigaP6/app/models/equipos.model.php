<?php 

class equiposModel {
    
    private $db;

    function __construct() {
        $this->db = new PDO('mysql:host=localhost;dbname=pes6;charset=utf8', 'root', '');
    }
    public function getEquipos() {
        $query = $this->db->prepare('SELECT nombre FROM equipos');
        $query->execute();
        $temporada = $query->fetchAll(PDO::FETCH_OBJ);
        return $temporada;
    }

}