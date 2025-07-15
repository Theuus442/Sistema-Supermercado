<?php

require_once __DIR__ . '/../lib/solicitacaoService.php';
require_once __DIR__ . '/../config/Connection.php';
require_once __DIR__ . '/../helpers/SessionHelper.php';
require_once __DIR__ . '/../lib/produtoService.php';

SessionHelper::requerPerfil('estoque');
SessionHelper::requerMetodoPost();

$solicitacao = SolicitacaoService::ultimaAprovadoPorPerfil(1);

if (!$solicitacao) {
    header('Location: ../views/index.php?erro=nao_liberado');
    exit;
}

$idProduto = $_POST['id_produto'] ?? null;
$nomeProduto = trim($_POST['nome'] ?? '');
$quantidade = $_POST['quantidade'] ?? '';
$preco = $_POST['preco'] ?? '';

if (
    !is_numeric($idProduto) || trim($nomeProduto) === '' || !is_numeric($quantidade) || (int) $quantidade < 1
    ||  !is_numeric($preco) || (float) $preco <= 0
) {
    header('Location: ../views/index.php?erro=campos');
    exit;
}

try {
    ProdutoService::atualizarProduto((int) $idProduto, $nomeProduto, (int) $quantidade, (float) $preco);
    header('Location: ../views/index.php?sucesso=produto_atualizado');
    exit;
} catch (PDOException $erro) {
    header('Location: ../views/index.php?erro=erro_banco');
    exit;
}
