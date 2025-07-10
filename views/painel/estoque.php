<?php

require_once __DIR__ . '/../../lib/produtos.php';


$produtos = getProdutos();

$liberado = false;
$caminhoSolicitacoes = __DIR__ . '/../../data/solicitacoes.json';

if (file_exists($caminhoSolicitacoes)) {
    $json = file_get_contents($caminhoSolicitacoes);
    $solicitacoes = json_decode($json, true);

    if (is_array($solicitacoes)) {
        $solicitacoesAdmin = array_filter($solicitacoes, function ($solicitacao) {
            return $solicitacao['usuario'] === 'admin';
        });

        usort($solicitacoesAdmin, function ($solicitacaoMaisRecente, $solicitacaoMaisAntiga) {
            return strtotime($solicitacaoMaisAntiga['data']) <=> strtotime($solicitacaoMaisRecente['data']);
        });


        if (!empty($solicitacoesAdmin)) {
            $ultimaSolicitacao = $solicitacoesAdmin[0];
            if ($ultimaSolicitacao['status'] === 'aprovado') {
                $liberado = true;
            }
        }
    }
}


?>

<h3>Painel do Estoque</h3>

<h4>Produtos</h4>

<ul>
    <?php foreach ($produtos as $produto): ?>
        <li>
            <?= htmlspecialchars($produto['nome_produto']) ?>
            - Quantidade <?= intval($produto['quantidade']) ?>
            - Preço: R$ <?= number_format($produto['preco'], 2, ',', '.') ?>
            <a href="painel/editar_produto.php?id_produto=<?= $produto['id_produto'] ?>">Editar</a>
        </li>
    <?php endforeach; ?>
</ul>

<h4>Inserir novo produto</h4>

<form action="../../lib/inserir_produto.php" method="post">
    <label for="nome">Nome:</label>
    <input type="text" name="nome" id="nome" required>

    <label for="quantidade">Quantidade:</label>
    <input type="number" name="quantidade" id="quantidade" min="1" required>

    <label for="preco">Preço:</label>
    <input type="number" step="0.01" name="preco" id="preco" required>

    <button type="submit">Cadastrar novo produto</button>
</form>


<?php if ($liberado): ?>
    <p>Você pode inserir, atualizar e excluir produtos!</p>
<?php else: ?>
    <p style="color: red;">Cadastro de produtos bloqueado! Aguarde liberação do financeiro.</p>
<?php endif; ?>