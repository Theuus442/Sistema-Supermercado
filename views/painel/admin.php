<?php

require_once __DIR__ . '/../config/Connection.php';
require_once __DIR__ . '/../../helpers/SessionHelper.php';
require_once __DIR__ . '/../../lib/solicitacaoService.php';
require_once __DIR__ . '/../../lib/adminService.php';
require_once __DIR__ . '/../../lib/produtoService.php';

SessionHelper::requerPerfil('admin');

$listaProdutos = ProdutoService::getProdutos();
$listaSolicitacoes = AdminService::listarSolicitacoesComUsuarios();
$solicitacaoPendenteExiste = SolicitacaoService::existeSolicitacaoPendente();

ob_start();
?>

<h3 class="mb-4 text-primary"><i class="bi bi-speedometer2"></i>Painel do Administrador</h3>

<h4>Produtos</h4>
<?php if (empty($listaProdutos)): ?>
    <p>Nenhum produto encontrado.</p>

<?php else: ?>
    <ul class="list-group mb-4">
        <?php foreach ($listaProdutos as $produto): ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <?= htmlspecialchars($produto['nome_produto']) ?>
                <span>
                    Quantidade: <span class="badge bg-primary rounded-pill"><?= intval($produto['quantidade']) ?></span>
                    &nbsp; | &nbsp;
                    Preço: R$ <?= number_format($produto['preco'], 2, ',', '.') ?>
                </span>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<h4>Solicitações</h4>
<?php if (empty($listaSolicitacoes)): ?>
    <p>Não há solicitações registradas.</p>
<?php else: ?>
    <ul class="list-group mb-4">
        <?php foreach ($listaSolicitacoes as $solicitacao): ?>
            <li class="list-group-item">
                <strong><?= htmlspecialchars($solicitacao['nome_usuario']) ?></strong> solicitou em
                <?= date('d/m/Y H:i', strtotime($solicitacao['data_solicitacao'])) ?>
                - Status: <strong><?= $solicitacao['status'] ?></strong>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php if ($solicitacaoPendenteExiste): ?>
    <div class="alert alert-warning" role="alert">
        Já existe uma solicitação pendente. Aguarde a resposta do time financeiro.
    </div>
<?php else: ?>
    <form method="post" action="../../actions/solicitacao.php" class="mb-4">
        <button type="submit" name="solicitar" class="btn btn-primary"><i class="bi bi-send"></i>Enviar solicitação ao financeiro</button>
    </form>
<?php endif; ?>

<?php
$conteudo = ob_get_clean();
$titulo = "Painel do Administrador";

require_once __DIR__ . '/../layout.php';