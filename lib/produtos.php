<?php 

function getProdutos(){
    $arquivoJson = __DIR__ . "/../data/produtos.json";

    if(!file_exists($arquivoJson)){
        return [];
    }

    $json = file_get_contents($arquivoJson);
    $produtos = json_decode($json, true);

    if(!is_array($produtos)){
        return [];
    }

    return $produtos;
}

?>