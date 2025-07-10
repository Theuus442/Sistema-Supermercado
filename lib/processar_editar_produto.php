<?php

session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['perfil'] !== 'estoque') {
    header('Location: ../views/login_form.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../views/dashboard.php');
    exit;
}

require_once __DIR__ . '/../Connection.php';

try {
    global $pdo;

    $sql = "SELECT status from solicitacoes WHERE id_perfil = 1 AND ativo = 1 ORDER BY data_aprovacao DESC LIMIT 1";

    $consulta = $pdo->query($sql);
    $ultimaSolicitacao = $consulta->fetch(PDO::FETCH_ASSOC);

    if (!$ultimaSolicitacao || $ultimaSolicitacao['status'] !== 'aprovado') {
        header('Location: ../views/dashboard.php?erro=nao_liberado');
        exit;
    }
} catch (PDOException $erro) {
    header('Location: ../views/dashboard.php?erro=erro_solicitacao');
    exit;
}

$idProduto = $_POST['id_produto'] ?? null;
$nomeProduto = $_POST['nome'] ?? '';
$quantidade = $_POST['quantidade'] ?? '';
$preco = $_POST['preco'] ?? '';

if (
    !is_numeric($idProduto) || trim($nomeProduto) === '' || !is_numeric($quantidade) || (int) $quantidade < 1
    ||  !is_numeric($preco) || (float) $preco <= 0
) {
    header('Location: ../views/dashboard.php?erro=campos');
    exit;
}

try {
    $sql = "UPDATE produtos SET nome_produto = :nome_produto, quantidade = :quantidade, preco = :preco WHERE id_produto = :id_produto AND existe = 1";
    $comandoAtualizarProduto = $pdo->prepare($sql);
    $comandoAtualizarProduto->execute([
        'nome_produto' => trim($nomeProduto),
        'quantidade' => (int) $quantidade,
        'preco' => (float) $preco,
        'id_produto' => (int) $idProduto
    ]);

    header('Location: ../views/dashboard.php?sucesso=produto_atualizado');
    exit;
} catch (PDOException $erro) {
    header('Location: ../views/dashboard.php?erro=erro_banco');
    exit;
}
