<?php

require_once "./config.php";

class UsuarioModel {

    private $db;

    function __construct () {
        $this->db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
    }

    function getUsuario ($usuario) {
        $query = $this->db->prepare('SELECT * FROM usuarios WHERE user = ?');
        $query->execute([$usuario]);
        $usuarioEncontrado = $query->fetch(PDO::FETCH_OBJ);
        return $usuarioEncontrado;
    }
}