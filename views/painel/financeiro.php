<?php

$arquivoJson = __DIR__ . '/../../data/solicitacoes.json';
$solicitacoes = [];

if (file_exists($arquivoJson)) {
    $json = file_get_contents($arquivoJson);
    $solicitacoes = json_decode($json, true);

    if (!is_array($solicitacoes)) {
        $solicitacoes = [];
    }
}
?>

<h3>Painel Financeiro</h3>

<?php if (empty($solicitacoes)): ?>
    <p>Não há solicitações no momento!</p>
<?php else: ?>
    <ul>
        <?php foreach ($solicitacoes as $sol): ?>
            <li>
                <?= htmlspecialchars($sol['usuario']) ?>
                - Solicitou em <?= date('d/m/Y H:i', strtotime($sol['data'])) ?>
                - Status: <strong><?= htmlspecialchars($sol['status']) ?></strong>
            </li>

            <?php if ($sol['status'] === 'pendente'): ?>
                <form action="../../lib/processar_solicitacao.php" method="post" style="display: inline;">
                    <input type="hidden" name="id" value="<?= $sol['id'] ?>">
                    <button type="submit" name="acao" value="aprovar">Aprovar</button>
                    <button type="submit" name="acao" value="negar">Negar</button>
                </form>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>