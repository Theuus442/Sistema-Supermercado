<?php
require_once __DIR__ . '/../../Connection.php';
require_once __DIR__ . '/../../lib/solicitacaoService.php';
require_once __DIR__ . '/../../helpers/SessionHelper.php';

SessionHelper::requerPerfil('financeiro');

$solicitacoes = SolicitacaoService::listarTodasSolicitacoes();
?>

<h3>Painel Financeiro</h3>

<?php if (empty($solicitacoes)): ?>
    <p>Não há solicitações no momento!</p>
<?php else: ?>
    <ul>
        <?php foreach ($solicitacoes as $sol): ?>
            <li style="margin-bottom: 12px;">
                <div>
                    <strong><?= htmlspecialchars($sol['username']) ?></strong> solicitou em
                    <?= date('d/m/Y H:i', strtotime($sol['data_solicitacao'])) ?>
                    - Status: <strong><?= htmlspecialchars($sol['status']) ?></strong>
                </div>

                <?php if ($sol['status'] === 'pendente'): ?>
                    <form action="../../actions/processar_solicitacao.php" method="post" style="margin-top: 4px;">
                        <input type="hidden" name="id_solicitacao" value="<?= $sol['id_solicitacao'] ?>">
                        <button type="submit" name="acao" value="aprovar">✅ Aprovar</button>
                        <button type="submit" name="acao" value="negar">❌ Negar</button>
                    </form>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>