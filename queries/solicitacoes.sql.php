<?php

return [
    'criar' => "INSERT INTO solicitacoes (id_perfil, nome_solicitacao, status, ativo, data_solicitacao) VALUES
    (:id_perfil, :nome_solicitacao, 'pendente', 1, NOW())",

    'ultima_aprovada_por_perfil' => "SELECT * FROM solicitacoes
        WHERE id_perfil = :id_perfil AND status = 'aprovado' AND
        ativo = 1 ORDER BY data_aprovacao DESC LIMIT 1",

    'existe_pendente' => "SELECT COUNT(*) as total FROM 
        solicitacoes WHERE status = 'pendente'",

    'processar_solicitacao' => "UPDATE solicitacoes SET status = :novo_status, data_aprovacao = NOW()
        WHERE id_solicitacao = :id AND status = 'pendente'",

    'ultima_solicitacao_por_perfil' => "SELECT * FROM solicitacoes 
        WHERE id_perfil = :id_perfil AND ativo = 1 
        ORDER BY data_solicitacao DESC LIMIT 1",


    'listar_todos' => "SELECT s.id_solicitacao, s.status, s.data_solicitacao, s.data_aprovacao, u.username
        FROM solicitacoes s 
        JOIN perfis p ON s.id_perfil = p.id_perfil 
        JOIN usuarios u ON p.id_usuario = u.id_usuario
        ORDER BY s.data_solicitacao DESC"
];

?>
