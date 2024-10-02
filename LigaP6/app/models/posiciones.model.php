<?php 

class PosicionesModel {
    
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

    public function getPosiciones($temporadas) {
        $query = $this->db->prepare('SELECT * FROM equipos JOIN jugadores ON equipos.Nombre = jugadores.Equipo  WHERE temporada = ? ORDER BY puntos DESC');
        $query->execute([$temporadas]);
        $posicion = $query->fetchAll(PDO::FETCH_OBJ);
        return $posicion;
    }

    public function actualizarPuntos($equipo_id, $puntos, $partidos_ganados, $partidos_perdidos,$partidos_empatados, $goles_a_favor, $goles_recibidos) {
        $query = $this->db->prepare("UPDATE equipos SET puntos = puntos + ?, partidos_ganados = partidos_ganados + ?, partidos_perdidos = partidos_perdidos + ?, partidos_empatados = partidos_empatados + ?,
        goles_a_favor = goles_a_favor + ?, goles_recibidos = goles_recibidos + ? WHERE nombre = ?");
        $query->execute([$puntos, $partidos_ganados, $partidos_perdidos, $partidos_empatados, $goles_a_favor, $goles_recibidos, $equipo_id]);
    }

    public function resetearPuntos() {
        $query = $this->db->prepare("UPDATE equipos SET puntos = 0, partidos_ganados = 0, partidos_empatados = 0, partidos_perdidos = 0, goles_a_favor = 0, goles_recibidos = 0");
        $query->execute();
    }
}