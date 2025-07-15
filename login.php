<?php

session_start();
require_once __DIR__ . '/config/Connection.php';
require_once __DIR__ . "/lib/UsuarioService.php";

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    
    $nomeUsuario = $_POST['usuario'] ?? '';
    $senha = $_POST['senha'] ?? '';

    $perfil = UsuarioService::autenticar($nomeUsuario, $senha);

    if($perfil !== false){
        $_SESSION['usuario'] = $nomeUsuario;
        $_SESSION['perfil'] = $perfil;
        header("Location: views/index.php");
        exit;
    } else {
        header("Location: views/login_form.php?erro=1");
        exit;
    }
}  else {
        header("Location:views/login_form.php");
        exit;
    }

?>