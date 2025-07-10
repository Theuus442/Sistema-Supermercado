<?php

session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['perfil'] !== 'financeiro') {
    header('Location: ../views/login_form.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_solicitacao'], $_POST['acao'])) {

    require_once __DIR__ . '/../Connection.php';

    $id = (int) $_POST['id_solicitacao'];
    $acao = $_POST['acao'];

    try {
        if ($acao === 'aprovar') {
            $sql = "UPDATE solicitacoes 
                    SET status = 'aprovado', data_aprovacao = NOW() 
                    WHERE id_solicitacao = :id AND status = 'pendente'";
        } elseif ($acao === 'negar') {
            $sql = "UPDATE solicitacoes 
                    SET status = 'negado', data_aprovacao = NOW() 
                    WHERE id_solicitacao = :id AND status = 'pendente'";
        } else {
            throw new Exception("Ação inválida");
        }

        $comandoAtualizaSolicitacao = $pdo->prepare($sql);
        $comandoAtualizaSolicitacao->execute(['id' => $id]);
    } catch (Exception $erro) {
        header('Location: ../views/dashboard.php?erro=erro_ao_processar');
        exit;
    }
}

header('Location: ../views/dashboard.php?sucesso=solicitacao_processada');
exit;
