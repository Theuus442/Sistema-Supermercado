<?php
if (!isset($_SESSION['usuario']) || $_SESSION['perfil'] !== 'financeiro') {
    header('Location: ../views/login_form.php');
    exit;
}

require_once __DIR__ . '/../../Connection.php';

$sql =  "SELECT s.id_solicitacao, s.status, s.data_solicitacao, s.data_aprovacao, u.username
    FROM solicitacoes s
    JOIN perfis p ON s.id_perfil = p.id_perfil
    JOIN usuarios u ON p.id_usuario = u.id_usuario
    ORDER BY s.data_solicitacao DESC";

$comandoAtualizarSolicitacoes = $pdo->query($sql);
$solicitacoes = $comandoAtualizarSolicitacoes->fetchAll(PDO::FETCH_ASSOC);
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
                    <form action="../../lib/processar_solicitacao.php" method="post" style="margin-top: 4px;">
                        <input type="hidden" name="id_solicitacao" value="<?= $sol['id_solicitacao'] ?>">
                        <button type="submit" name="acao" value="aprovar">✅ Aprovar</button>
                        <button type="submit" name="acao" value="negar">❌ Negar</button>
                    </form>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>