<?php
class AuthHelper {

    public static function init() {
        if (session_status() != PHP_SESSION_ACTIVE) {
            session_start();
        }
    }
    
    public static function login($usuario) {
        AuthHelper::init();
        $_SESSION['id_usuario'] = $usuario->id;
        $_SESSION['usuario'] = $usuario->user;
        $_SESSION['password'] = $usuario->password;
        $_SESSION['rol'] = $usuario->role; 
    }

    public static function logout() {
        AuthHelper::init();
        session_destroy();
    }
    public static function checkSession() {
        AuthHelper::init();
        if(!isset($_SESSION['usuario'])){
            header('Location: ' . inicio);
            die();
        }
    }

    public static function verify() {
        AuthHelper::init();
        if (isset($_SESSION['usuario'])) {
            if($_SESSION['rol'] == "admin"){
                return true;
            } else {
                return false;
            }
        }
    }
}
