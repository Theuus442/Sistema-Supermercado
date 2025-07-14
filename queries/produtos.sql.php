<?php

return [
    'buscar_todos' => "SELECT * from produtos WHERE existe = 1 ORDER BY id_produto DESC",

    'buscar_por_id' => "SELECT * from produtos WHERE id_produto = :id AND existe = 1",

    'excluir_logico' => "UPDATE produtos SET existe = 0 WHERE id_produto = :id_produto",

    'inserir' => "INSERT INTO produtos (nome_produto, quantidade, preco, existe) VALUES (:nome_produto, :quantidade, :preco, 1)",
    
    'atualizar' => "UPDATE produtos SET nome_produto = :nome_produto, quantidade = :quantidade, preco = :preco WHERE id_produto = :id_produto AND existe = 1",

    'buscar_por_nome_excluido' => "SELECT * FROM produtos WHERE nome_produto = :nome_produto AND existe = 0 LIMIT 1",

    'reativar_produto' => "UPDATE produtos SET quantidade = :quantidade, preco = :preco, existe = 1 WHERE id_produto = :id_produto",

];

?>