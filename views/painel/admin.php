<?php

$produtos = getProdutos();

$arquivoSolicitacoes = __DIR__  . '../../data/solicitacoes.json';
$solicitacoes = [];

if (file_exists($arquivoSolicitacoes)) {
    $json = file_get_contents($arquivoSolicitacoes);
    $solicitacoes = json_decode($json, true);

    if (!is_array($solicitacoes)) {
        $solicitacoes = [];
    }
}

function existeSolicitacaoPendente(array $solicitacoes): bool
{
    foreach ($solicitacoes as $sol) {
        if ($sol['status'] === 'pendente') {
            return true;
        }
    }

    return false;
}
?>

<h3>Painel do administrador</h3>
<h4>Produtos</h4>
<ul>
    <?php foreach ($produtos as $produto): ?>
        <li>
            <?= htmlspecialchars($produto['nome']) ?>
            - Quantidade - <?= intval($produto['quantidade']) ?>
            - Preço: R$ <?= number_format($produto['preco'], 2, ',', '.') ?>
        </li>
    <?php endforeach; ?>
</ul>

<h4>Solicitações</h4>
<?php if (empty($solicitacoes)): ?>
    <p>Não há Solicitações registradas!</p>
<?php else: ?>
    <ul>
        <?php foreach ($solicitacoes as $sol): ?>
            <li>
                Solicitação
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>


<?php if (existeSolicitacaoPendente($solicitacoes)): ?>
    <p>Já existe uma solicitação pendente! Aguarde a resposta do time financeiro.</p>
<?php else: ?>
    <form method="post" action="../../lib/solicitação.php">
        <button type="submit" name="solicitar">Enviar solicitação ao financeiro</button>
    </form>
<?php endif; ?>