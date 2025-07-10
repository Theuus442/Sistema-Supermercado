<?php

session_start();
require_once __DIR__ . '/config.php';

if (!isset($_SESSION['usuario']) || $_SESSION['perfil'] !== 'admin') {
    header('Location: ../views/login_form.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['solicitar'])){
    header('Location: ../views/dashboard.php');
}

require_once __DIR__ . '/../Connection.php';

try {
    $verifica = $pdo->prepare("SELECT COUNT(*) as total FROM solicitacoes WHERE status = 'pendente'");
    $verifica->execute();
    $resultado = $verifica->fetch(PDO::FETCH_ASSOC);

    if($resultado['total'] > 0){
        header('Location: ../views/dashboard.php?erro=solicitacao_existente');
        exit;
    }

    $sql = "INSERT INTO solicitacoes (id_perfil, nome_solicitacao, status, ativo, data_solicitacao)
    VALUES (:id_perfil, :nome_solicitacao, 'pendente', 1, NOW())";

    $comandoInserir = $pdo->prepare($sql);
    $comandoInserir->execute([
        'id_perfil' => 1,
        'nome_solicitacao' => 'liberação_estoque'
    ]);

    header('Location: ../views/dashboard.php?sucesso=solicitacao_enviada');
    exit;
} catch (PDOException $e){
    header('Location: ../views/dashboard.php?erro=erro_banco');
    exit;
}