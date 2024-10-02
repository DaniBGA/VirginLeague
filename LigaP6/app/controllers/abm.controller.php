<?php

require_once "./app/views/abm.view.php";
require_once "./app/models/fixture.model.php";
require_once './app/models/equipos.model.php';
require_once "./app/views/error.view.php";

class ABMController {

    private $abmView;
    private $fixturemodel;
    private $equiposmodel;
    private $errorView;

    function __construct () {
        $this->abmView = new ABMView();
        $this->fixtureModel = new fixtureModel();
        $this->equiposModel = new equiposModel();
        $this->errorView = new ErrorView();
    }
    
    function showAgregar () {
        $fecha = $_GET['fecha'];
        if (AuthHelper::verify()) {
            if (!$fecha) {
                $this->errorView->showError("La fecha no existe.");
                return;
            }
            $equipos = $this->equiposModel->getEquipos();  // Traes los equipos disponibles
            $this->abmView->showAgregar($fecha, $equipos);
        } else {
            header('Location: ' . inicio);
        }
    }

    function addPartido (){
        if (AuthHelper::verify()) {
            if (!isset($_POST['equipo_local']) || !isset($_POST['goles_local'])  || !isset($_POST['equipo_visita']) || !isset($_POST['goles_visita'])) {
                $this->errorView->showError("Falta completar datos");
                return;
            }
            $equipos = $this->equiposModel->getEquipos();

            $fecha = $_POST['fecha'];
            $equipo_local = $_POST['equipo_local'];
            $goles_local = $_POST['goles_local'];
            $equipo_visita = $_POST['equipo_visita'];
            $goles_visita = $_POST['goles_visita'];

            if (!$this->fixtureModel->getFecha($fecha)) {
                $this->errorView->showError("La fecha no existe en la tabla de fechas.");
                return;
            }
            // Aquí guardas el partido usando el modelo
            if ($equipo_local === $equipo_visita) {
                $this->errorView->showError("El equipo local y el equipo visitante no pueden ser el mismo.");
                return;
            }
            
            if (!$equipo_local || !$equipo_visita) {
                $this->errorView->showError("Alguno de los equipos seleccionados no existe");
                return;
            }

            $partidos = $this->fixtureModel->getpartidos();
            foreach ($equipos as $equipo) {
                if ($equipo_local == $equipo->nombre && $equipo_visita == $equipo->nombre) {
                    $this->errorView->showError("ya existe ese partido");
                    return;
                }
            }
                $this->fixtureModel->addPartido($fecha, $equipo_local, $equipo_visita, $goles_local, $goles_visita);
                header('Location: https://www.virginleague.site/partidos/' . $fecha);
            }
        }
    function deletePartido($id) {
        if (!isset($_GET['fecha'])) {
            $this->errorView->showError("La fecha no fue proporcionada.");
            return;
        }
        $fecha = $_GET['fecha'];
        if (AuthHelper::verify()) {
            $this->fixtureModel->removePartido($id);
            header('Location: https://www.virginleague.site/partidos/' . $fecha);
            exit; // Siempre es buena práctica hacer un exit después de header
        } else {
            header('Location: ' . inicio);
            exit; // También un exit aquí
        }
    }

    function showUpdateProducto ($id) {
        if (AuthHelper::verify()) {
            $producto = $this->productosModel->getProductoUnico($id);
            if ($producto) {
                $categorias = $this->categoriaModel->getCategorias();
                $this->abmView->showUpdateProducto($categorias, $producto);
            } else {
                $this->errorView->showError("El producto no existe");
            }
        } else {
            header('Location: ' . HOME);
        };
    }

    function updateProducto ($id_producto) {
        if (AuthHelper::verify()) {
            if (empty($_POST['nombre']) || empty($_POST['descripcion']) || empty($_POST['precio']) || empty($_POST['categoria'])) {
                $this->errorView->showError("Falta completar datos");
                return;
            }

            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $precio = $_POST['precio'];
            $id_categoria = $_POST['categoria'];

            $producto = $this->productosModel->getProductoUnico($id_producto);
            if (!$producto) {
                $this->errorView->showError("El producto no existe");
                return;
            }

            $productos = $this->productosModel->getProductosMenosUno($id_producto);
            foreach ($productos as $producto) {
                if ($nombre == $producto->nombre) {
                    $this->errorView->showError("Ya existe un producto con este nombre");
                    return;
                }
            }
            $this->productosModel->updateProducto($nombre, $descripcion, $precio, $id_categoria, $id_producto);
            header('Location: ' . JUEGOS);
        } else {
            header('Location: ' . HOME);
        }
    }
}