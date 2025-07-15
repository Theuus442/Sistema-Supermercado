<?php
require_once __DIR__ . '/../config/Connection.php';
require_once __DIR__ . '/ProdutoService.php';

class VendaService
{
    private static array $sql = [];

    private static function carregarSQL(): void
    {
        if (empty(self::$sql)) {
            self::$sql = require __DIR__ . '/../queries/vendas.sql.php';
        }
    }

    public static function iniciarVenda(int $idUsuario): int
    {
        global $pdo;
        self::carregarSQL();

        $stmt = $pdo->prepare(self::$sql['iniciar_venda']);
        $stmt->execute(['id_usuario' => $idUsuario]);
        return (int) $pdo->lastInsertId();
    }

    public static function buscarVendaAberta(int $idUsuario): ?array
    {
        global $pdo;
        self::carregarSQL();

        $stmt = $pdo->prepare(self::$sql['buscar_venda_aberta']);
        $stmt->execute(['id_usuario' => $idUsuario]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public static function adicionarItem(int $idVenda, int $idProduto, int $quantidade, float $precoUnitario): bool
    {
        global $pdo;
        self::carregarSQL();

        // Verifica se tem estoque suficiente
        $produto = ProdutoService::getProdutoPorId($idProduto);
        if (!$produto || $produto['quantidade'] < $quantidade) {
            return false;
        }

        $stmt = $pdo->prepare(self::$sql['adicionar_item']);
        $resultado = $stmt->execute([
            'id_venda' => $idVenda,
            'id_produto' => $idProduto,
            'quantidade' => $quantidade,
            'preco_unitario' => $precoUnitario
        ]);

        if ($resultado) {
            self::atualizarTotal($idVenda);
        }
        return $resultado;
    }

    public static function removerItem(int $idVenda, int $idProduto): bool
    {
        global $pdo;
        self::carregarSQL();

        $stmt = $pdo->prepare(self::$sql['remover_item']);
        $resultado = $stmt->execute([
            'id_venda' => $idVenda,
            'id_produto' => $idProduto,
        ]);

        if ($resultado) {
            self::atualizarTotal($idVenda);
        }
        return $resultado;
    }

    public static function atualizarTotal(int $idVenda): bool
    {
        global $pdo;
        self::carregarSQL();

        $stmt = $pdo->prepare(self::$sql['atualizar_total']);
        return $stmt->execute(['id_venda' => $idVenda]);
    }

    public static function finalizarVenda(int $idVenda): bool
    {
        global $pdo;
        self::carregarSQL();

        try {
            $pdo->beginTransaction();

            $itens = self::buscarItensVenda($idVenda);

            foreach ($itens as $item) {
                $produto = ProdutoService::getProdutoPorId($item['id_produto']);

                if (!$produto || $produto['quantidade'] < $item['quantidade']) {
                    $pdo->rollBack();
                    return false;
                }

                // Atualizar estoque
                $stmt = $pdo->prepare(file_get_contents(__DIR__ . '/../queries/produtos/diminuir_estoque.sql'));
                $stmt->execute([
                    'id_produto' => $item['id_produto'],
                    'quantidade' => $item['quantidade']
                ]);

                if ($stmt->rowCount() === 0) {
                    $pdo->rollBack();
                    return false;
                }
            }

            // Finalizar venda
            $stmtFinalizar = $pdo->prepare(self::$sql['finalizar_venda']);
            $stmtFinalizar->execute(['id_venda' => $idVenda]);

            $pdo->commit();
            return true;
        } catch (Exception $e) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            return false;
        }
    }

    public static function buscarItensVenda(int $idVenda): array
    {
        global $pdo;
        self::carregarSQL();

        $stmt = $pdo->prepare(self::$sql['buscar_itens_venda']);
        $stmt->execute(['id_venda' => $idVenda]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
