<?php

class ABMView {

    function showAgregar ($fecha, $equipos) {
        require "templates/agregar.phtml";
    }

    function showAddCategoria () {
        require "templates/addCategoria.phtml";
    }

    function showUpdateProducto ($categorias, $producto) {
        require "templates/updateProducto.phtml";
    }

    function showUpdateCategoria ($categoria) {
        require "templates/updateCategoria.phtml";
    }
}