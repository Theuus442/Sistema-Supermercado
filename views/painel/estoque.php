<?php

require_once __DIR__ . '/../../lib/produtos.php';


$produtos = getProdutos();

$arquivoPermissao = __DIR__ . '/../../data/permissao_estoque.json';
$liberado = false;

if (file_exists($arquivoPermissao)) {
    $json = file_get_contents($arquivoPermissao);
    $dados = json_decode($json, true);

    if (isset($dados['liberado']) && $dados['liberado'] === true) {
        $liberado = true;
    }
}
?>

<h3>Painel do Estoque</h3>

<h4>Produtos</h4>

<ul>
    <?php foreach ($produtos as $produto): ?>
        <li>
            <?= htmlspecialchars($produto['nome']) ?>
            - Quantidade: <?= intval($produto['quantidade']) ?>
            - Preço: R$ <?= number_format($produto['preco'], 2, ',', '.') ?>
        </li>
    <?php endforeach; ?>
</ul>

<h4>Inserir novo produto</h4>

<form action="../../lib/inserir_produto.php" method="post">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" required>

        <label for="quantidade">Quantidade:</label>
        <input type="number" name="quantidade" id="quantidade" min="1" required>

        <label for="preco">Preço:</label>
        <input type="number" step="0.01" name="preco" id="preco" required>

        <button type="submit">Cadastrar novo produto</button>
</form>


<?php if ($liberado): ?>
    <p>Você pode inserir, atualizar e excluir produtos!</p>
    <ul>
        <li><a href="#">Inserir produto</a></li>
        <li><a href="#">Atualizar produto</a></li>
        <li><a href="#">Excluir produto</a></li>
    </ul>
<?php else: ?>
    <p style="color: red;">Cadastro de produtos bloqueado! Aguarde liberação do financeiro.</p>
<?php endif; ?>