<?php 

class inicioModel {
    private $db;

    function __construct() {
        $this->db = new PDO('mysql:host=localhost;dbname=pes6;charset=utf8', 'root', '');
    }


}