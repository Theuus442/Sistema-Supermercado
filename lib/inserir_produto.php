<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../views/dashboard.php');
    exit;
}

require_once __DIR__ . '/../Connection.php';

$nomeProduto = trim($_POST['nome'] ?? '');
$quantidadeProduto = $_POST['quantidade'] ?? '';
$precoProduto = $_POST['preco'] ?? '';
$idCategoria = $_POST['id_categoria'] ?? 1;

if ($nomeProduto === '' || !is_numeric($quantidadeProduto) || !is_numeric($precoProduto)) {
    header('Location: ../views/dashboard.php?erro=campos_invalidos');
    exit;
}

try {
    $sqlBuscarProduto = "SELECT * FROM produtos WHERE nome_produto = :nome_produto AND existe = 0 LIMIT 1";
    $consultaProdutoExcluido = $pdo->prepare($sqlBuscarProduto);
    $consultaProdutoExcluido->execute(['nome_produto' => $nomeProduto]);
    $produtoExistente = $consultaProdutoExcluido->fetch(PDO::FETCH_ASSOC);

    if ($produtoExistente) {
        $sqlAtualizarProduto = "UPDATE produtos 
            SET quantidade = :quantidade, preco = :preco, existe = 1 
            WHERE id_produto = :id_produto";

        $consultaAtualizarProduto = $pdo->prepare($sqlAtualizarProduto);
        $consultaAtualizarProduto->execute([
            'quantidade' => (int) $quantidadeProduto,
            'preco' => (float) $precoProduto,
            'id_produto' => (int) $produtoExistente['id_produto']
        ]);
    } else {
        $sqlInserirProduto = "INSERT INTO produtos (nome_produto, quantidade, preco, id_categoria, existe) 
            VALUES (:nome_produto, :quantidade, :preco, :id_categoria, 1)";
        $comandoInserirProduto = $pdo->prepare($sqlInserirProduto);
        $comandoInserirProduto->execute([
            'nome_produto' => $nomeProduto,
            'quantidade' => (int) $quantidadeProduto,
            'preco' => (float) $precoProduto,
            'id_categoria' => (int) $idCategoria
        ]);
    }

    header('Location: ../views/dashboard.php?sucesso=produto_salvo');
    exit;
} catch (PDOException $erro) {
    header('Location: ../views/dashboard.php?erro=erro_banco');
    exit;
}
