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
    $consultaSolicitacao = $pdo->prepare("SELECT * FROM solicitacoes WHERE id_perfil = 1 
    AND status = 'aprovado' AND ativo = 1 ORDER BY data_aprovacao DESC LIMIT 1");

    $consultaSolicitacao->execute();

    $solicitacao = $consultaSolicitacao->fetch(PDO::FETCH_ASSOC);

    if (!$solicitacao) {
        header('Location: ../views/dashboard.php?erro=nao_liberado');
        exit;
    }
} catch (PDOException $e) {
    echo "Erro no banco: " . $e->getMessage();
    exit;
}

$idProduto = $_POST['id_produto'] ?? null;

if (!is_numeric($idProduto)) {
    header('Location: ../views/dashboard.php?erro=id_invalido');
    exit;
}

try {
    $atualizaProduto = $pdo->prepare("UPDATE produtos SET existe = 0 WHERE id_produto = :id_produto");
    $atualizaProduto->execute(['id_produto' => (int)$idProduto]);

    header('Location: ../views/dashboard.php?sucesso=produto_excluido');
    exit;
} catch (PDOException $e) {
    echo "Erro no banco: " . $e->getMessage();
    exit;
}
