<?php 

class fixtureModel {
    
    private $db;

    function __construct() {
        $this->db = new PDO('mysql:host=localhost;dbname=pes6;charset=utf8', 'root', '');
    }

    public function getTemporadas() {
        $query = $this->db->prepare('SELECT * FROM temporadas');
        $query->execute();
        $temporada = $query->fetchAll(PDO::FETCH_OBJ);
        return $temporada;
    }

    public function getTemporadaPorFecha($fecha) {
        $query = $this->db->prepare("SELECT t.ID
                                      FROM fechas f 
                                      JOIN temporadas t ON f.temporada = t.ID 
                                      WHERE f.id_fecha = :fecha");
        $query->execute([':fecha' => $fecha]);
        $temporada = $query->fetch(PDO::FETCH_OBJ);
        return $temporada ? $temporada->ID : null; // Cambia a nombre_temporada
    }
    public function addTemporada($id) {
        $query = $this->db->prepare('INSERT INTO temporadas(ID) VALUES (?)');
        $query->execute([$id]);
    }
    public function deleteTemporada($id){
        $query = $this->db->prepare('INSERT INTO temporadas(ID) VALUES (?)');
        $query->execute([$id]);
    }

    public function getFechas($temporadas) {
        $query = $this->db->prepare('SELECT * FROM fechas WHERE temporada = ?');
        $query->execute([$temporadas]);
        $temporada = $query->fetchAll(PDO::FETCH_OBJ);
        return $temporada;
    }
    public function getPartidosFecha($fechaId) {
    $query = $this->db->prepare("SELECT f.*, fe.temporada 
                                   FROM fixture f 
                                   JOIN fechas fe ON f.fecha = fe.id_fecha 
                                   WHERE f.fecha = :fechaId");
    $query->execute([':fechaId' => $fechaId]);
    return $query->fetchAll(PDO::FETCH_OBJ); // Deberías recibir un array de objetos
    }
    public function getFecha($fechaId) {
        $query = $this->db->prepare('SELECT * FROM fechas WHERE id_fecha = ?');
        $query->execute([$fechaId]);
        return $query->fetch(PDO::FETCH_OBJ);  // Asumiendo que solo esperas un resultado
    }

    public function addPartido($fecha, $equipo_local, $equipo_visita, $goles_local, $goles_visita) {
        $query = $this->db->prepare('INSERT INTO fixture(fecha, equipo_local, equipo_visita, goles_local, goles_visita) VALUES (?, ?, ?, ? ,?)');
        $query->execute([$fecha, $equipo_local, $equipo_visita, $goles_local, $goles_visita]);
    }

    public function getPartidos(){
        $query = $this->db->prepare('SELECT * FROM fixture');
        $query->execute([]);
        $partidos = $query->fetchAll(PDO::FETCH_OBJ);
        return $partidos;
    }
    function updatePartido ($fecha, $equipo_local, $goles_local, $goles_visita, $equipo_visita, $id_partido){
        $query = $this->db->prepare('UPDATE fixture SET fecha = ?, equipo_local = ?, goles_local = ?, goles_visita = ?, equipo_visita = ? WHERE id_partido = ?');
        $query->execute([$fecha, $equipo_local, $goles_local, $goles_visita, $equipo_visita, $id_partido]);
    }

    function removePartido ($id){
        $query = $this->db->prepare('DELETE FROM fixture WHERE id_partido = ?');
        $query->execute([$id]);
    }

}
