<?php

session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['perfil'] !== 'estoque') {
    header('Location: ../views/login_form.php');
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../views/dashboard.php');
    exit;
}

$liberado = false;

$caminhoSolicitacoes = __DIR__ . '/../data/solicitacoes.json';

if (file_exists($caminhoSolicitacoes)) {
    $json = file_get_contents($caminhoSolicitacoes);
    $solicitacoes = json_decode($json, true);

    if (is_array($solicitacoes)) {
        $solicitacoesAdmin = array_filter($solicitacoes, function ($solicitacao) {
            return $solicitacao['usuario'] === 'admin';
        });

        usort($solicitacoesAdmin, function ($solicitacaoMaisRecente, $solicitacaoMaisAntiga) {
            return strtotime($solicitacaoMaisAntiga['data']) <=> strtotime($solicitacaoMaisRecente['data']);
        });

        if (!empty($solicitacoesAdmin) && $solicitacoesAdmin[0]['status'] === 'aprovado') {
            $liberado = true;
        }
    }
}

if (!$liberado) {
    header('Location: ../views/dashboard.php?erro=nao_liberado');
    exit;
}

$indice = $_POST['indice'] ?? null;

if (!is_numeric($indice)) {
    header('Location: ../views/dashboard.php?erro=indice_invalido');
    exit;
}

$caminhoProdutos = __DIR__ . '/../data/produtos.json';
$produtos = [];


if (file_exists($caminhoProdutos)) {
    $json = file_get_contents($caminhoProdutos);
    $produtos = json_decode($json, true);

    if (!is_array($produtos)) {
        $produtos = [];
    }
}

if (!isset($produtos[$indice])) {
    header('Location: ../views/dashboard.php?erro=produto_nao_encontrado');
    exit;
}

unset($produtos[$indice]);
$produtos = array_values($produtos);

file_put_contents($caminhoProdutos, json_encode($produtos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

header('Location: ../views/dashboard.php?sucesso=produto_excluido');
exit;