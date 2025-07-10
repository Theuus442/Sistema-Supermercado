<?php

require_once __DIR__ . '/../../Connection.php';

if (!isset($_SESSION['usuario']) || $_SESSION['perfil'] !== 'admin') {
    header('Location: ../views/login_form.php');
    exit();
}

$sqlSelecionarProdutosAtivos = "
    SELECT nome_produto, quantidade, preco 
    FROM produtos 
    WHERE existe = 1 
    ORDER BY nome_produto
";

$consultaProdutosAtivos = $pdo->query($sqlSelecionarProdutosAtivos);
$listaProdutos = $consultaProdutosAtivos->fetchAll(PDO::FETCH_ASSOC);


$sqlSolicitacoes = "
    SELECT s.id_solicitacao, s.status, s.data_solicitacao, s.data_aprovacao, u.username AS nome_usuario
    FROM solicitacoes s
    JOIN perfis p ON s.id_perfil = p.id_perfil
    JOIN usuarios u ON p.id_usuario = u.id_usuario
    ORDER BY s.data_solicitacao DESC
";

$consultaSolicitacoes = $pdo->query($sqlSolicitacoes);
$listaSolicitacoes = $consultaSolicitacoes->fetchAll(PDO::FETCH_ASSOC);

$solicitacaoPendenteExiste = false;

foreach ($listaSolicitacoes as $solicitacao) {
    if ($solicitacao['status'] === 'pendente') {
        $solicitacaoPendenteExiste = true;
        break;
    }
}
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
    <form method="post" action="../../lib/solicitacao.php">
        <button type="submit" name="solicitar">Enviar solicitação ao financeiro</button>
    </form>
<?php endif; ?>
