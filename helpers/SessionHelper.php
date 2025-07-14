<?php

class SessionHelper{
    public static function iniciarSessao(){
        if(session_status() === PHP_SESSION_NONE){
            session_start();
        }
    }

    public static function requerPerfil(string $perfil){
        self::iniciarSessao();

        if(!isset($_SESSION['usuario']) || $_SESSION['perfil'] !== $perfil){
            header('Location: ../views/login_form.php');
            exit;
        }
    }

    public static function requerMetodoPost(){
        if ($_SERVER['REQUEST_METHOD'] !== 'POST'){
            header('Location: ../views/index.php');
            exit;
        }
    }

    public static function requerLogin(){
        self::iniciarSessao();

        if(!isset($_SESSION['usuario']) || !isset($_SESSION['perfil'])){
            header('Location: login_form.php');
            exit;
        }
    }


}