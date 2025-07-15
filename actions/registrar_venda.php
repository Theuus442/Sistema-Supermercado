<?php
require_once __DIR__ . '/../lib/produtoService.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idProduto = (int) ($_POST['id_produto'] ?? 0);
    $quantidade = (int) ($_POST['quantidade'] ?? 0);

    if ($idProduto > 0 && $quantidade > 0) {
        $ok = ProdutoService::diminuirEstoque($idProduto, $quantidade);
        if ($ok) {
            header('Location: ../views/index.php?msg=vendido');
            exit;
        } else {
            header('Location: ../views/index.php?erro=estoque_insuficiente');
            exit;
        }
    }
}

header('Location: ../views/index.php?erro=dados_invalidos');
exit;
