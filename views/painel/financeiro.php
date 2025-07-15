<?php
require_once __DIR__ . '/../config/Connection.php';
require_once __DIR__ . '/../../lib/solicitacaoService.php';
require_once __DIR__ . '/../../helpers/SessionHelper.php';

SessionHelper::requerPerfil('financeiro');

$solicitacoes = SolicitacaoService::listarTodasSolicitacoes();

ob_start();
?>

<h3 class="mb-4 text-primary"><i class="bi bi-cash-coin"></i>Painel Financeiro</h3>

<?php if (empty($solicitacoes)): ?>
    <div class="alert alert-info" role="alert">
        <i class="bi bi-info-circle"></i> Não há solicitações no momento!
    </div>
<?php else: ?>
    <ul class="list-group mb-4">
        <?php foreach ($solicitacoes as $sol): ?>
            <li class="list-group-item">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <strong><?= htmlspecialchars($sol['username']) ?></strong> solicitou em
                        <?= date('d/m/Y H:i', strtotime($sol['data_solicitacao'])) ?> <br>
                        - Status:
                        <?php if ($sol['status'] === 'pendente'): ?>
                            <span class="badge bg-warning text-dark">Pendente</span>
                        <?php elseif ($sol['status'] === 'aprovado'): ?>
                            <span class="badge bg-success">Aprovado</span>
                        <?php else: ?>
                            <span class="badge bg-danger">Negado</span>
                        <?php endif; ?>
                    </div>

                    <?php if ($sol['status'] === 'pendente'): ?>
                        <form action="../../actions/processar_solicitacao.php" method="post" class="d-flex gap-2 align-items-center">
                            <input type="hidden" name="id_solicitacao" value="<?= $sol['id_solicitacao'] ?>">

                            <button type="submit" name="acao" value="aprovar"
                                class="btn btn-success btn-sm"><i class="bi bi-check-circle"></i>aprovar</button>

                            <button type="submit" name="acao" value="negar" class="btn btn-danger btn-sm"><i class="bi bi-x-circle">Negar</i></button>
                        </form>
                    <?php endif; ?>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php

$conteudo = ob_get_clean();
$titulo = "Painel Financeiro";

require_once __DIR__ . '/../layout.php';
