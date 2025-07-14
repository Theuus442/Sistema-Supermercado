<?php
require_once __DIR__ . '/../Connection.php';

class ProdutoService
{
    private static array $sql;

    private static function carregarSQL()
    {
        if (!isset(self::$sql)) {
            self::$sql = require __DIR__ . '/../queries/produtos.sql.php';
        }
    }

    public static function getProdutos(): array
    {
        global $pdo;
        self::carregarSQL();

        try {
            $consulta = $pdo->query(self::$sql['buscar_todos']);
            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public static function getProdutoPorId(int $idProduto): ?array
    {
        global $pdo;
        self::carregarSQL();

        try {
            $consultaProduto = $pdo->prepare(self::$sql['buscar_por_id']);
            $consultaProduto->execute(['id' => $idProduto]);

            return $consultaProduto->fetch(PDO::FETCH_ASSOC) ?: null;
        } catch (PDOException $erro) {
            return null;
        }
    }

    public static function excluirProduto(int $id)
    {
        global $pdo;
        self::carregarSQL();

        $comandoExecutar = $pdo->prepare(self::$sql['excluir_logico']);
        return $comandoExecutar->execute(['id_produto' => $id]);
    }

    public static function inserirProduto(string $nome, int $quantidade, float $preco, int $idCategoria = 1)
    {
        global $pdo;
        self::carregarSQL();

        $comando = $pdo->prepare(self::$sql['inserir']);
        return $comando->execute([
            'nome' => $nome,
            'quantidade' => $quantidade,
            'preco' => $preco,
            'id_categoria' => $idCategoria
        ]);
    }

    public static function reativarProduto(int $id, int $quantidade, float $preco)
    {
        global $pdo;
        self::carregarSQL();

        $comando = $pdo->prepare(self::$sql['reativar_produto']);
        return $comando->execute([
            'id_produto' => $id,
            'quantidade' => $quantidade,
            'preco' => $preco
        ]);
    }

    public static function atualizarProduto(int $id, string $nome, int $quantidade, float $preco)
    {
        global $pdo;
        self::carregarSQL();

        $comando = $pdo->prepare(self::$sql['atualizar']);
        return $comando->execute([
            'id_produto' => $id,
            'nome_produto' => $nome,
            'quantidade' => $quantidade,
            'preco' => $preco
        ]);
    }

    public static function buscarProdutoExcluidoPorNome(string $nome)
    {
        global $pdo;
        self::carregarSQL();

        $comando = $pdo->prepare(self::$sql['buscar_por_nome_excluido']);
        $comando->execute(['nome_produto' => $nome]);
        return $comando->fetch(PDO::FETCH_ASSOC);
    }
}
