<h3>Painel do Produto</h3>

<?php $produtos = getProdutos(); ?>

<ul>
    <?php foreach ($produtos as $produto): ?>
        <li>
            <?= htmlspecialchars($produto['nome_produto']) ?> - Quantidade: <?= intval($produto['quantidade']) ?> - Preço: R$ <?= number_format($produto['preco'], 2, ',', '.') ?>
        </li>
    <?php endforeach; ?>
</ul>

<button onclick="alert('Venda realizada com sucesso!')">Registrar Venda</button>