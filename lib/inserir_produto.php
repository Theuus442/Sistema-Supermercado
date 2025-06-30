<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location:../views/dashboard.php');
    exit;
}

$nome = $_POST['nome'] ?? '';
$quantidade = $_POST['quantidade'] ?? '';
$preco = $_POST['preco'] ?? '';

if (trim($nome) === '' ||  !is_numeric($quantidade) || !is_numeric($preco)) {
    header('Location: ../views/dashboard.php?erro=campos');
    exit;
}

$caminho = __DIR__ . '/../data/produtos.json';
$produtos = [];

if (file_exists($caminho)) {
    $json = file_get_contents($caminho);
    $produtos = json_decode($json, true);
    if (!is_array($produtos)) {
        $produtos = [];
    }
}

if (!preg_match('/[a-zA-ZÀ-ÿ]/u', $nome)) {
    header('Location: ../views/dashboard.php?erro=nome_invalido');
    exit;
}

$produtos[] = [
    'nome' => trim($nome),
    'quantidade' => (int) $quantidade,
    'preco' => (float) $preco
];

file_put_contents($caminho, json_encode($produtos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

header('Location: ../views/dashboard.php');
exit;
