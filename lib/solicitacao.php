<?php

session_start();
require_once __DIR__ . 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['solicitar'])) {

    if (!isset($_SESSION['usuario']) || $_SESSION['perfil'] !== 'admin') {
        header('Location: ../views/login_form.php');
        exit();
    }

    $arquivo = __DIR__ . '/../data/solicitacoes.json';

    $solicitacoes = [];

    if (file_exists($arquivo)) {
        $json = file_get_contents($arquivo);
        $solicitacoes = json_decode($json, true);

        if (!is_array($solicitacoes)) {
            $solicitacoes = [];
        }
    }

    $novaSolicitacao = [
        'id' => time(),
        'usuario' => $_SESSION['usuario'],
        'status' => 'pendente',
        'data' => date('Y-m-d H:i:s'),
    ];

    $solicitacoes[] = $novaSolicitacao;

    file_put_contents($arquivo, json_encode($solicitacoes, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

    header('Location: ../views/dashboard.php');
    exit;
} else {
    header('Location: ../views/dashboard.php');
    exit;
}
