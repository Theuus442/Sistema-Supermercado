<?php

session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['perfil'] !== 'estoque') {
    header('Location: ../login_form.php');
    exit;
}

if (!isset($_GET['indice']) || !is_numeric($_GET['indice'])) {
    header('Location: dashboard.php');
    exit;
}

$indice = (int) $_GET['indice'];
$caminho = __DIR__ . '/../../data/produtos.json';

$produtos = [];

if (file_exists($caminho)) {
    $json = file_get_contents($caminho);
    $produtos = json_decode($json, true);

    if (!is_array($produtos)) {
        $produtos = [];
    }
}

if (!isset($produtos[$indice])) {
    header('Location: dashboard.php');
    exit;
}

$produto = $produtos[$indice];

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Produto</title>
</head>
<body>
    <h3>Editar Produto</h3>

    <form action="../../lib/processar_editar_produto.php" method="post">
        <input type="hidden" name="indice" value="<?= $indice ?>" />
        
        <label for="nome">Nome:</label><br>
        <input type="text" id="nome" name="nome" required value="<?= htmlspecialchars($produto['nome']) ?>" />
        <br><br>

        <label for="quantidade">Quantidade:</label><br>
        <input type="number" id="quantidade" min="1" name="quantidade" required value="<?= intval($produto['quantidade']) ?>" />
        <br><br>

        <label for="preco">Preço:</label><br>
        <input type="number" id="preco" name="preco" step="0.01" required 
        value="<?= number_format($produto['preco'], 2, '.', '') ?>" />
        <br><br>
        
        <button type="submit">Salvar Alterações</button>
    </form>
    <br>
    <form action="../../lib/excluir_produto.php" method="post" onsubmit="return confirm('Tem certeza que deseja excluir este produto?')">
        <input type="hidden" name="indice" value="<?= $indice ?>" />
        <button type="submit" style="color: red;">Excluir Produto</button>
    </form>


    <br>

    <a href="../dashboard.php">Voltar ao Dashboard</a>

</body>
</html>