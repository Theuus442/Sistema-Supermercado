<?php

function getUsers(): array {
    return [
        'caixa' => ['senha' => '123', 'perfil' => 'caixa'],
        'estoque' => ['senha' => '123', 'perfil' => 'estoque'],
        'admin' => ['senha' => '123', 'perfil' => 'admin'],
        'financeiro' => ['senha' => '123', 'perfil' => 'financeiro'],
    ];
}

function autenticarUser(string $nomeUsuario, string $senha){
    $usuarios = getUsers();

    if(!isset($usuarios[$nomeUsuario])){
        return false;
    }

    if($usuarios[$nomeUsuario]['senha'] !== $senha){
        return false;
    }

    return $usuarios[$nomeUsuario]['perfil'];

}


?>