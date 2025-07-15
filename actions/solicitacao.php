<?php

require_once __DIR__ . '/../lib/configService.php';
require_once __DIR__ . '/../config/Connection.php';
require_once __DIR__ . '/../helpers/SessionHelper.php';
require_once __DIR__ . '/../lib/solicitacaoService.php';

SessionHelper::requerPerfil('admin');
SessionHelper::requerMetodoPost();

if (SolicitacaoService::existeSolicitacaoPendente()) {
    header('Location: ../views/index.php?erro=solicitacao_existente');
    exit;
}

try {
    $resultado = SolicitacaoService::criarSolicitacao(1, 'liberação_estoque');
    if ($resultado) {
        header('Location: ../views/index.php?sucesso=solicitacao_enviada');
    } else {
        header('Location: ../views/index.php?erro=falha_criacao');
    }

    exit;
} catch (PDOException $e) {
    header('Location: ../views/index.php?erro=erro_banco');
    exit;
}
