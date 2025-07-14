<?php

class UsuarioService
{
    private static array $sql;

    private static function carregarSQL()
    {
        if (!isset(self::$sql)) {
            self::$sql = require __DIR__ . '/../queries/usuarios.sql.php';
        }
    }

    public static function autenticar(String $username, string $senha)
    {
        global $pdo;
        self::carregarSQL();

        $comando = $pdo->prepare(self::$sql['buscar_por_username']);
        $comando->execute(['username' => $username]);
        $usuario = $comando->fetch(PDO::FETCH_ASSOC);

        if ($usuario && $senha === $usuario['senha']) {
            return $usuario['username'];
        }

        return false;
    }
}
