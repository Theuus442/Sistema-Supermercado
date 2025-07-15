<?php

require_once __DIR__ . '/../lib/solicitacaoService.php';
require_once __DIR__ . '/../helpers/SessionHelper.php';
require_once __DIR__ . '/../config/Connection.php';
require_once __DIR__ . '/../lib/produtoService.php';

SessionHelper::requerPerfil('estoque');
SessionHelper::requerMetodoPost();

$solicitacao = SolicitacaoService::ultimaAprovadoPorPerfil(1);

if (!$solicitacao){
    header('Location: ../views/index.php?erro=acesso_bloqueado');
    exit;
}

$nomeProduto = trim($_POST['nome'] ?? '');
$quantidadeProduto = $_POST['quantidade'] ?? '';
$precoProduto = $_POST['preco'] ?? '';
$idCategoria = $_POST['id_categoria'] ?? 1;

if ($nomeProduto === '' || !is_numeric($quantidadeProduto) || !is_numeric($precoProduto)) {
    header('Location: ../views/index.php?erro=campos_invalidos');
    exit;
}

try {
    $produtoExcluido = ProdutoService::buscarProdutoExcluidoPorNome($nomeProduto);

    if ($produtoExcluido) {
        ProdutoService::reativarProduto(
            $produtoExcluido['id_produto'],
            (int) $quantidadeProduto,
            (float) $precoProduto
        );
    } else {
        ProdutoService::inserirProduto(
            $nomeProduto,
            (int) $quantidadeProduto,
            (float) $precoProduto,
            (int) $idCategoria
        );
    }

    header('Location: ../views/index.php?sucesso=produto_salvo');
    exit;
} catch (PDOException $erro) {
    header('Location: ../views/index.php?erro=erro_banco');
    exit;
}
