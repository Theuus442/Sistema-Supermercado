<h3>Painel do Produto</h3>

<?php
require_once __DIR__ . '/../../lib/produtoService.php';
$produtos = ProdutoService::getProdutos();?>

<ul>
    <?php foreach ($produtos as $produto): ?>
        <li>
            <?= htmlspecialchars($produto['nome_produto']) ?> - Quantidade: <?= intval($produto['quantidade']) ?> - Preço: R$ <?= number_format($produto['preco'], 2, ',', '.') ?>
        </li>
    <?php endforeach; ?>
</ul>

<button onclick="alert('Venda realizada com sucesso!')">Registrar Venda</button>