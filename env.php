<?php

function loadEnv($caminho){
    if(!file_exists($caminho)){
        throw new Exception((".env não encontrado: $caminho"));
    }

    $linhas = file($caminho, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($linhas as $linha){
        if(str_starts_with(trim($linha), '#')) continue;

        [$chave, $valor] = explode('=', $linha, 2);
        putenv(trim($chave) . '=' . trim($valor));
    }
}


?>