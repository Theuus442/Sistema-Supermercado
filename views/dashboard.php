<?php

session_start();

if (!isset($_SESSION['usuario']) || !isset($_SESSION['perfil'])){
    header("Location: login_form.php");
    exit();
}

$usuario = $_SESSION['usuario'];
$perfil = $_SESSION['perfil'];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema Supermercado</title>
</head>
<body>
    <h2>Bem vindo, <?= htmlspecialchars($usuario) ?>!</h2>
    <p>Seu perfil: <strong><?=htmlspecialchars($perfil) ?></strong></p>
    <hr>

    <?php if ($perfil === 'caixa'):?>
        <h3>Painel do Caixa</h3>
        <ul>
            <li><a href="#">Ver lista de produtos</a></li>
            <li><a href="#">Registrar venda</a></li>
        </ul>

    <?php elseif($perfil === 'estoque'):?>
        <h3>Painel do Estoque</h3>
        <ul>
            <li><a href="#">Visualizar produtos</a></li>
            <li><a href="#">Inserir/Atualizar/Excluir produtos</a></li>
        </ul>
    <?php elseif($perfil === 'admin'):?>
        <h3>Painel do Administrador</h3>
        <ul>
            <li><a href="#">Visualizar tudo</a></li>
            <li><a href="#">Solicitar liberação ao financeiro</a></li>
        </ul>
    <?php elseif($perfil === 'financeiro'):?>
        <h3>Painel do financeiro</h3>
        <ul>
            <li><a href="#">Visualizar solicitações</a></li>
            <li><a href="#">Aprovar ou negar cadastro</a></li>
        </ul>
    <?php else: ?>
        <p>Perfil não reconhecido</p>
    <?php endif;?>

    <br>
    <a href="logout.php">Sair</a>
</body>
</html>