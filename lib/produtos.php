<?php
require_once __DIR__ . '/../Connection.php';

function getProdutos()
{
    global $pdo;

    try {
        $consulta = $pdo->query("SELECT * from produtos WHERE existe = 1 ORDER BY id_produto DESC");
        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return [];
    }
}

function getProdutoPorId(int $idProduto)
{
    global $pdo;


    try {
        $sql = "SELECT * from produtos WHERE id_produto = :id AND existe = 1";
        $consultaProduto = $pdo->prepare($sql);
        $consultaProduto->execute(['id' => $idProduto]);

        $produtoEncontrado = $consultaProduto->fetch(PDO::FETCH_ASSOC);
        return $produtoEncontrado ?: null;
    } catch (PDOException $erro) {
        return null;
    }
}
