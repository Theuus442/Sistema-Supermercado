<?php

require_once __DIR__ . '/../../lib/produtoService.php';
require_once __DIR__ . '/../../Connection.php';
require_once __DIR__ . '/../../lib/solicitacaoService.php';

$ultimaSolicitacao = SolicitacaoService::ultimaSolicitacaoPorPerfil(1);
$liberado = $ultimaSolicitacao && $ultimaSolicitacao['status'] === 'aprovado';

$produtos = ProdutoService::getProdutos();
?>

<h3>Painel do Estoque</h3>

<h4>Produtos</h4>

<ul>
    <?php foreach ($produtos as $produto): ?>
        <li>
            <?= htmlspecialchars($produto['nome_produto']) ?>
            - Quantidade <?= intval($produto['quantidade']) ?>
            - Preço: R$ <?= number_format($produto['preco'], 2, ',', '.') ?>
            <?php if ($liberado): ?>
                - <a href="painel/editar_produto.php?id_produto=<?= $produto['id_produto'] ?>">Editar</a>
            <?php else: ?>
                - <span style="color: gray;">Editar (bloqueado)</span>
            <?php endif; ?>
        </li>
    <?php endforeach; ?>
</ul>

<?php if ($liberado): ?>
    <h4>Inserir novo produto</h4>

    <form action="../../actions/inserir_produto.php" method="post">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" required>

        <label for="quantidade">Quantidade:</label>
        <input type="number" name="quantidade" id="quantidade" min="1" required>

        <label for="preco">Preço:</label>
        <input type="number" step="0.01" name="preco" id="preco" required>

        <button type="submit">Cadastrar novo produto</button>
    </form>
    <p>Você pode inserir, atualizar e excluir produtos!</p>
<?php else: ?>
    <p style="color: red;">Cadastro de produtos bloqueado! Aguarde liberação do financeiro.</p>
<?php endif; ?>
