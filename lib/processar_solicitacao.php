<?php

session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['perfil'] !== 'financeiro') {
    header('Location: ../views/login_form.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['acao'])) {
    $id = $_POST['id'];
    $acao = $_POST['acao'];

    $arquivoJson = __DIR__ . '/../data/solicitacoes.json';

    if (file_exists($arquivoJson)) {
        $json = file_get_contents($arquivoJson);
        $solicitacoes = json_decode($json, true);

        if (is_array($solicitacoes)) {
            foreach ($solicitacoes as &$solicitacao) {
                if ($solicitacao['id'] == $id && $solicitacao['status'] === 'pendente') {
                    if ($acao === 'aprovar') {
                        $solicitacao['status'] = 'aprovado';
                        file_put_contents(__DIR__ . '/../data/permissao_estoque.json', json_encode(['liberado' => true]));
                    } elseif ($acao === 'negar') {
                        $solicitacao['status'] = 'negado';
                    }
                    break;
                }
            }
            file_put_contents($arquivoJson, json_encode($solicitacoes, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        }
    }
}

header('Location: ../views/dashboard.php');
exit();