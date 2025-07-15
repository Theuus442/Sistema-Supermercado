<?php
require_once __DIR__ . '/../../helpers/SessionHelper.php';
require_once __DIR__ . '/../../lib/produtoService.php';

SessionHelper::requerPerfil('caixa');
$produtos = ProdutoService::getProdutos();

// Início da captura do conteúdo da página
ob_start();
?>

<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-success text-white">
            <h5><i class="bi bi-cart-check"></i> Registrar Venda</h5>
        </div>
        <div class="card-body">
            <form action="/../actions/registrar_venda.php" method="post" onsubmit="return validarVenda();">
                <div class="mb-3">
                    <label for="id_produto" class="form-label">Produto:</label>
                    <select name="id_produto" id="id_produto" class="form-select" required onchange="preencherInfoProduto()">
                        <option value="">Selecione um produto</option>
                        <?php foreach ($produtos as $p): ?>
                            <option value="<?= $p['id_produto'] ?>"
                                data-nome="<?= htmlspecialchars($p['nome_produto']) ?>"
                                data-preco="<?= number_format($p['preco'], 2, '.', '') ?>">
                                <?= htmlspecialchars($p['nome_produto']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nome do Produto:</label>
                    <input type="text" id="nome_produto" class="form-control" readonly>
                </div>

                <div class="mb-3">
                    <label for="quantidade" class="form-label">Quantidade:</label>
                    <input type="number" name="quantidade" id="quantidade" class="form-control" min="1" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Preço Unitário:</label>
                    <input type="text" id="preco_produto" class="form-control" readonly>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check2-circle"></i> Vender
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    function preencherInfoProduto() {
        const select = document.getElementById('id_produto');
        const nome = select.options[select.selectedIndex].getAttribute('data-nome');
        const preco = select.options[select.selectedIndex].getAttribute('data-preco');
        document.getElementById('nome_produto').value = nome || '';
        document.getElementById('preco_produto').value = preco || '';
    }

    function validarVenda() {
        const select = document.getElementById('id_produto');
        const quantidade = document.getElementById('quantidade').value;
        if (!select.value || quantidade < 1) {
            alert('Selecione um produto e uma quantidade válida.');
            return false;
        }
        return true;
    }
</script>

<?php
$conteudo = ob_get_clean();
$titulo = "Registrar Venda";
require_once __DIR__ . '/../layout.php';
