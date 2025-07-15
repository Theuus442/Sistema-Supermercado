<?php
require_once __DIR__ . '/../../lib/produtoService.php';
$produtos = ProdutoService::getProdutos();

$mensagem = $_GET['msg'] ?? '';
?>

<div class="container mt-5">
    <h3 class="text-primary mb-4">
        <i class="bi bi-cart-check"></i> Painel do Produto
    </h3>

    <?php if ($mensagem): ?>
        <div class="alert alert-success"><?= htmlspecialchars($mensagem) ?></div>
    <?php endif; ?>


    <table class="table table-striped table-hover">
        <thead class="table-primary">
            <tr>
                <th>Produto</th>
                <th>Quantidade em estoque</th>
                <th>Preço</th>
                <th>Ação</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($produtos as $produto): ?>
                <tr>
                    <td><?= htmlspecialchars($produto['nome_produto']) ?></td>
                    <td><?= intval($produto['quantidade']) ?></td>
                    <td>R$ <?= number_format($produto['preco'], 2, ',', '.') ?></td>
                    <td>
                        <?php if($produto['quantidade'] > 0): ?>
                            <form action="/views/painel/registrar_venda.php" method="post" class="d-inline">
                                <input type="hidden" name="id_produto" value="<?= $produto['id_produto'] ?>">
                                <button type="submit" class="btn btn-success btn-sm"><i class="bi bi-bag-check"></i> Vender
                            </button>
                            </form>
                            <?php else: ?>
                                <button class="btn btn-secondary btn-sm" disabled>Esgotado</button>
                                <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    </div>