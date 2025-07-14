<?php


require_once __DIR__ . '/../../helpers/SessionHelper.php';

SessionHelper::requerPerfil('estoque');

if (!isset($_GET['id_produto']) || !is_numeric($_GET['id_produto'])) {
    header('Location: index.php');
    exit;
}

$idProdutoSelecionado = (int) $_GET['id_produto'];

require_once __DIR__ . '/../../lib/produtoService.php';

$produtoSelecionado = ProdutoService::getProdutoPorId($idProdutoSelecionado);

if (!$produtoSelecionado) {
    header('Location: index.php?erro=produto_nao_encontrado');
    exit;
}

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

    <form action="../../actions/processar_editar_produto.php" method="post">
        <input type="hidden" name="id_produto" value="<?= $produtoSelecionado['id_produto'] ?>" />

        <label for="nome">Nome:</label><br>
        <input type="text" id="nome" name="nome" required value="<?= htmlspecialchars($produtoSelecionado['nome_produto']) ?>" />
        <br><br>

        <label for="quantidade">Quantidade:</label><br>
        <input type="number" id="quantidade" min="1" name="quantidade" required value="<?= intval($produtoSelecionado['quantidade']) ?>" />
        <br><br>

        <label for="preco">Preço:</label><br>
        <input type="number" id="preco" name="preco" step="0.01" required
            value="<?= number_format($produtoSelecionado['preco'], 2, '.', '') ?>" />
        <br><br>

        <button type="submit">Salvar Alterações</button>
    </form>
    <br>
    <form action="../../actions/excluir_produto.php" method="post" onsubmit="return confirm('Tem certeza que deseja excluir este produto?')">
        <input type="hidden" name="id_produto" value="<?= $produtoSelecionado['id_produto'] ?>" />
        <button type="submit" style="color: red;">Excluir Produto</button>
    </form>


    <br>

    <a href="../index.php">Voltar à tela inicial</a>

</body>

</html>