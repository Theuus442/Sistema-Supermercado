<?php
require_once __DIR__ . '/../../helpers/SessionHelper.php';
SessionHelper::requerPerfil('estoque');

require_once __DIR__ . '/../../lib/produtoService.php';

if (!isset($_GET['id_produto']) || !is_numeric($_GET['id_produto'])) {
    header('Location: index.php');
    exit;
}

$idProdutoSelecionado = (int) $_GET['id_produto'];
$produtoSelecionado = ProdutoService::getProdutoPorId($idProdutoSelecionado);

if (!$produtoSelecionado) {
    header('Location: index.php?erro=produto_nao_encontrado');
    exit;
}

// MONTA O CONTEÚDO HTML EM UMA VARIÁVEL
ob_start();
?>

<!-- Aqui vai todo o HTML do conteúdo -->
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-pencil-square"></i> Editar Produto</h5>
            </div>

            <div class="card-body">
                <form action="../../actions/processar_editar_produto.php" method="post" class="row g-3">
                    <input type="hidden" name="id_produto" value="<?= $produtoSelecionado['id_produto'] ?>">

                    <div class="col-md-6">
                        <label for="nome" class="form-label">Nome:</label>
                        <input type="text" id="nome" name="nome" class="form-control" required
                            value="<?= htmlspecialchars($produtoSelecionado['nome_produto']) ?>">
                    </div>

                    <div class="col-md-3">
                        <label for="quantidade" class="form-label">Quantidade:</label>
                        <input type="number" id="quantidade" name="quantidade" class="form-control" min="1" required
                            value="<?= intval($produtoSelecionado['quantidade']) ?>">
                    </div>

                    <div class="col-md-3">
                        <label for="preco" class="form-label">Preço:</label>
                        <input type="number" id="preco" name="preco" step="0.01" class="form-control" required
                            value="<?= number_format($produtoSelecionado['preco'], 2, '.', '') ?>">
                    </div>

                    <div class="col-12 text-end mt-4">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-save2"></i> Salvar Alterações
                        </button>
                    </div>
                </form>

                <form action="../../actions/excluir_produto.php" method="post" class="mt-3"
                    onsubmit="return confirm('Tem certeza que deseja excluir este produto?')">
                    <input type="hidden" name="id_produto" value="<?= $produtoSelecionado['id_produto'] ?>">
                    <button type="submit" class="btn btn-outline-danger w-100">
                        <i class="bi bi-trash"></i> Excluir Produto
                    </button>
                </form>
            </div>

            <div class="card-footer text-start">
                <a href="../index.php" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Voltar à tela inicial
                </a>
            </div>
        </div>
    </div>
</div>

<?php
$conteudo = ob_get_clean(); // <- captura todo o HTML acima e guarda na variável
$titulo = "Editar Produto";

require_once __DIR__ . '/../layout.php';
