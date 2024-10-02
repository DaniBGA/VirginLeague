<?php
require_once "./app/controllers/inicio.controller.php";
require_once "./app/controllers/fixture.controller.php";
require_once "./app/controllers/posiciones.controller.php";
require_once "./app/controllers/abm.controller.php";
require_once "./app/controllers/auth.controller.php";
require_once "./app/controllers/error.controller.php";

define('inicio', '//'.$_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']).'/inicio');
define('partidos', '//'.$_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']).'/partidos');

$action = 'inicio';
if (!empty($_GET['action'])) {
    $action = $_GET['action'];
}



$params = explode('/', $action);

switch ($params[0]) {
        case 'inicio':
            $controllerInicio = new inicioController();
            $controllerInicio->showInicio();
            break;
        case 'login':
            $controller = new AuthController();
            $controller->showLogin();
            break;
        case 'auth':
            $controller = new AuthController();
            $controller->auth();
            break;
        case 'temporada':
            $controller = new FixtureController();
            $controller->mostrarTemporadas();
            break;
        case 'fixture':
            $controller = new FixtureController();
            $controller->mostrarFechas($params[1]);
            break;
        case 'partidos':
            $controller = new FixtureController();
            $controller->showPartidosFecha($params[1], $params[1]);
            break;
        case 'añadir':
            $controller = new ABMController();
            $controller->showAgregar();
            break;
        case 'añadirPartido':
            $controller = new ABMController();
            $controller->addPartido();
            break;
        case 'eliminar':
            $controller = new ABMController();
            $controller->deletePartido($params[1]);
            break;
        case 'posicionesTemp':
            $controller = new PosicionesController();
            $controller->mostrarTemporadas();
            break;
         case 'posiciones':
            $controller = new PosicionesController();
            $controller->resetearPuntos();
            $controller->calcularPuntos();
            $controller->mostrarPosiciones($params[1]);
            break;
        case 'logout':
            $controller = new AuthController();
            $controller->logout();
            break;
        default:
            $controller = new ErrorController();
            $controller->showError("Page Not Found");
            break;
}