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

        if (!empty($solicitacoesAdmin)) {
            $ultimaSolicitacao = $solicitacoesAdmin[0];
            if ($ultimaSolicitacao['status'] === 'aprovado') {
                $liberado = true;
            }
        }
    }
}

if (!$liberado){
    header('Location: ../views/dashboard.php?erro=nao_liberado');
    exit;
}





$indice = $_POST['indice'] ?? null;
$nome = $_POST['nome'] ?? '';
$quantidade = $_POST['quantidade'] ?? '';
$preco = $_POST['preco'] ?? '';

if (!is_numeric($indice) || trim($nome) === '' || !is_numeric($quantidade) || !is_numeric($preco)) {
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

if (!isset($produtos[$indice])) {
    header('Location: ../views/dashboard.php?erro=produto_nao_encontrado');
    exit;
}

$produtos[$indice]['nome'] = trim($nome);
$produtos[$indice]['quantidade'] = (int) $quantidade;
$produtos[$indice]['preco'] = (float) $preco;

file_put_contents($caminho, json_encode($produtos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

header('Location: ../views/dashboard.php');

exit;
