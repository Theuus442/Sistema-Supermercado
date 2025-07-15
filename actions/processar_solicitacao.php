<?php

require_once __DIR__ . '/../config/Connection.php';
require_once __DIR__ . '/../lib/solicitacaoService.php';
require_once __DIR__ . '/../helpers/SessionHelper.php';

SessionHelper::requerPerfil('financeiro');
SessionHelper::requerMetodoPost();

if (!isset($_POST['id_solicitacao'], $_POST['acao'])) {
    header('Location: ../views/index.php?erro=dados_incompletos');
    exit;
}

$id = (int) $_POST['id_solicitacao'];
$acao = $_POST['acao'];

$acoesPermitidas = ['aprovar', 'negar'];
if (!in_array($acao, $acoesPermitidas, true)) {
    header('Location: ../views/index.php?erro=acao_invalida');
    exit;
}

try {
    SolicitacaoService::processarSolicitacao($id, $acao);
    header('Location: ../views/index.php?sucesso=solicitacao_processada');
    exit;
} catch (Exception $erro) {
    header('Location: ../views/index.php?erro=erro_ao_processar');
    exit;
}
