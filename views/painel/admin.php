<?php

require_once __DIR__ . '/../../Connection.php';
require_once __DIR__ . '/../../helpers/SessionHelper.php';
require_once __DIR__ . '/../../lib/solicitacaoService.php';
require_once __DIR__ . '/../../lib/adminService.php';
require_once __DIR__ . '/../../lib/produtoService.php';

SessionHelper::requerPerfil('admin');

$listaProdutos = ProdutoService::getProdutos();
$listaSolicitacoes = AdminService::listarSolicitacoesComUsuarios();
$solicitacaoPendenteExiste = SolicitacaoService::existeSolicitacaoPendente();

?>

<h3>Painel do Administrador</h3>

<h4>Produtos</h4>
<ul>
    <?php foreach ($listaProdutos as $produto): ?>
        <li>
            <?= htmlspecialchars($produto['nome_produto']) ?>
            - Quantidade: <?= intval($produto['quantidade']) ?>
            - Preço: R$ <?= number_format($produto['preco'], 2, ',', '.') ?>
        </li>
    <?php endforeach; ?>
</ul>

<h4>Solicitações</h4>
<?php if (empty($listaSolicitacoes)): ?>
    <p>Não há solicitações registradas.</p>
<?php else: ?>
    <ul>
        <?php foreach ($listaSolicitacoes as $solicitacao): ?>
            <li>
                <?= htmlspecialchars($solicitacao['nome_usuario']) ?> solicitou em
                <?= date('d/m/Y H:i', strtotime($solicitacao['data_solicitacao'])) ?>
                - Status: <strong><?= $solicitacao['status'] ?></strong>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php if ($solicitacaoPendenteExiste): ?>
    <p>Já existe uma solicitação pendente. Aguarde a resposta do time financeiro.</p>
<?php else: ?>
    <form method="post" action="../../actions/solicitacao.php">
        <button type="submit" name="solicitar">Enviar solicitação ao financeiro</button>
    </form>
<?php endif; ?>
