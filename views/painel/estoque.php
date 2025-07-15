<?php

require_once __DIR__ . '/../../lib/produtoService.php';
require_once __DIR__ . '/../config/Connection.php';
require_once __DIR__ . '/../../lib/solicitacaoService.php';

$ultimaSolicitacao = SolicitacaoService::ultimaSolicitacaoPorPerfil(1);
$liberado = $ultimaSolicitacao && $ultimaSolicitacao['status'] === 'aprovado';

$produtos = ProdutoService::getProdutos();
?>

<h3 class="text-success mb-4"><i class="bi bi-box-seam"></i>Painel do Estoque</h3>

<h4>Produtos</h4>

<table class="table table-striped table-hover table-bordered">
    <thead class="table-dark">
        <tr>
            <th>Nome</th>
            <th>Quantidade</th>
            <th>Preço</th>
            <th>Ação</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($produtos as $produto): ?>
            <tr>
                <td><?= htmlspecialchars($produto['nome_produto']) ?></td>
                <td><?= intval($produto['quantidade']) ?></td>
                <td><?= number_format($produto['preco'], 2, ',', '.') ?></td>
                <td>
                    <?php if ($liberado): ?>
                        <a href="painel/editar_produto.php?id_produto=<?= $produto['id_produto'] ?>" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-pencil-square"></i> Editar
                        </a>
                    <?php else: ?>
                        <span class="text-muted">Editar (bloqueado)</span>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php if ($liberado): ?>
    <h4 class="mt-5">Inserir novo produto</h4>

    <form action="../../actions/inserir_produto.php" method="post" class="row g-3">
        <div class="col-md-4">
            <label for="nome" class="form-label">Nome:</label>
            <input type="text" name="nome" id="nome" class="form-control" required>
        </div>
        <div>
            <label for="quantidade" class="form-label">Quantidade:</label>
            <input type="number" name="quantidade" id="quantidade" class="form-control" min="1" required>
        </div>
        <div class="col-md-4">
            <label for="preco" class="form-label">Preço:</label>
            <input type="number" step="0.01" name="preco" id="preco" class="form-control" required>
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-success">Cadastrar novo produto</button>
        </div>
    </form>

    <div class="alert alert-info mt-3">
        Você pode inserir, atualizar e excluir produtos!
    </div>
<?php else: ?>
    <div class="alert alert-danger mt-3">
        <i class="bi bi-lock-fill"></i>Cadastro de produtos bloqueado! Aguarde liberação do financeiro.
    </div>
<?php endif; ?>