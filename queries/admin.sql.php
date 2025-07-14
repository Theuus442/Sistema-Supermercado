<?php

return [
    'produtos_ativos' => "SELECT nome_produto, quantidade, preco 
    FROM produtos 
    WHERE existe = 1 
    ORDER BY nome_produto
",
    'solicitacoes_com_usuarios' => "SELECT s.id_solicitacao, s.status, s.data_solicitacao, s.data_aprovacao, u.username AS nome_usuario
    FROM solicitacoes s
    JOIN perfis p ON s.id_perfil = p.id_perfil
    JOIN usuarios u ON p.id_usuario = u.id_usuario
    ORDER BY s.data_solicitacao DESC
",
];
