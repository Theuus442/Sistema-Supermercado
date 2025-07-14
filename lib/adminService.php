<?php

require_once __DIR__ . '/../Connection.php';

class AdminService
{
    private static array $sql;

    private static function carregarSQL()
    {
        if (!isset(self::$sql)) {
            self::$sql = require __DIR__ . '/../queries/admin.sql.php';
        }
    }

    public static function listarSolicitacoesComUsuarios()
    {
        global $pdo;
        self::carregarSQL();

        try {
            $consulta = $pdo->query(self::$sql['solicitacoes_com_usuarios']);
            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $erro) {
            return [];
        }
    }
}
