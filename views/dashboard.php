<?php

session_start();
require_once __DIR__ . '/../lib/config.php';

if (!isset($_SESSION['usuario']) || !isset($_SESSION['perfil'])) {
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
    <p>Seu perfil: <strong><?= htmlspecialchars($perfil) ?></strong></p>
    <hr>

    <?php
    require_once __DIR__ . '/../lib/produtos.php';

    switch ($perfil) {
        case 'caixa':
            include __DIR__ . '/painel/caixa.php';
            break;
        case 'estoque':
            include __DIR__ . '/painel/estoque.php';
            break;
        case 'admin':
            include __DIR__ . '/painel/admin.php';
            break;
        case 'financeiro':
            include __DIR__ . '/painel/financeiro.php';
            break;
        default:
            echo "<p>Perfil não reconhecido.</p>";
    }
    ?>

    <br>
    <a href="logout.php">Sair</a>
</body>

</html>