<?php

require_once __DIR__ . '/../lib/solicitacaoService.php';
require_once __DIR__ . '/../helpers/SessionHelper.php';
require_once __DIR__ . '/../Connection.php';
require_once __DIR__ . '/../lib/produtoService.php';

SessionHelper::requerPerfil('estoque');
SessionHelper::requerMetodoPost();

$solicitacao = SolicitacaoService::ultimaAprovadoPorPerfil(1);

if (!$solicitacao) {
    header('Location: ../views/index.php?erro=nao_liberado');
    exit;
}

$idProduto = $_POST['id_produto'] ?? null;

if (!is_numeric($idProduto)) {
    header('Location: ../views/index.php?erro=id_invalido');
    exit;
}

try {
    $sucesso = ProdutoService::excluirProduto((int) $idProduto);
    if ($sucesso) {
        header('Location: ../views/index.php?sucesso=produto_excluido');
    } else {
        header('Location: ../views/index.php?erro=nao_excluido');
    }
    exit;
} catch (PDOException $e) {
    header('Location: ../views/index.php?erro=erro_banco');
    exit;
}
