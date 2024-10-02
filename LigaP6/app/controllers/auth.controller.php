<?php

require_once "./app/views/auth.view.php";
require_once "./app/models/usuario.model.php";
require_once './app/helpers/auth.helper.php';
require_once "./app/views/error.view.php";

class AuthController {

    private $model;
    private $view;
    private $errorView;

    function __construct () {
        $this->model = new UsuarioModel;
        $this->view = new AuthView;
        $this->errorView = new ErrorView;
    }

    function showLogin () {
        $this->view->showLogin();
    }

    function auth () {
        $nombre_usuario = $_POST['usuario'];
        $password = $_POST['password'];
        if (empty($nombre_usuario) || empty($password)) {
            $this->errorView->showError("Falta completar datos");
            return;
        }
        $usuario = $this->model->getUsuario($nombre_usuario);

        if ($usuario && password_verify($password, $usuario->password)) {

            AuthHelper::login($usuario);

            header('Location: ' . inicio);
        } else {
            $this->view->showLogin("Usuario invalido");
        }
    }

    public function logout() {
        AuthHelper::logout();
        header('Location: ' . inicio);    
    }
}