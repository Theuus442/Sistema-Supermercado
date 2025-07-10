<?php
require_once __DIR__ . '/../Connection.php';
function autenticarUser(string $nomeUsuario, string $senha)
{
    try {
        $pdo = new PDOConnection();

        $sql = "SELECT username, senha FROM usuarios WHERE username = :username AND ativo = 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['username' => $nomeUsuario]);
        $usuario = $stmt->fetch();

        if ($usuario && $senha === $usuario['senha']) {
            return $usuario['username'];
        }

        return false;
    } catch (PDOException $e) {
        die("Erro na autenticação: " . $e->getMessage());
    }
}
