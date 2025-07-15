<?php

require_once __DIR__ . '/../config/Connection.php';

class SolicitacaoService
{
    private static array $sql;

    private static function carregarSQL()
    {
        if (!isset(self::$sql)) {
            self::$sql = require __DIR__ . '/../queries/solicitacoes.sql.php';
        }
    }

    public static function criarSolicitacao(int $idPerfil, string $nomeSolicitacao){
        global $pdo;
        self::carregarSQL();

        $sql = self::$sql['criar'];
        $comando = $pdo->prepare($sql);

        return $comando->execute([
            'id_perfil' => $idPerfil,
            'nome_solicitacao' => $nomeSolicitacao
        ]);
    }

    public static function ultimaAprovadoPorPerfil(int $idPerfil)
    {
        global $pdo;
        self::carregarSQL();

        $sql = self::$sql['ultima_aprovada_por_perfil'];
        $comandoExecutar = $pdo->prepare($sql);
        $comandoExecutar->execute(['id_perfil' => $idPerfil]);

        return $comandoExecutar->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public static function existeSolicitacaoPendente()
    {
        global $pdo;
        self::carregarSQL();

        $sql = self::$sql['existe_pendente'];
        $comandoExecutar = $pdo->query($sql);

        $resultado = $comandoExecutar->fetch(PDO::FETCH_ASSOC);
        return $resultado['total'] > 0;
    }

    public static function processarSolicitacao(int $idSolicitacao, string $acao)
    {
        global $pdo;
        self::carregarSQL();

        $acoesPermitidas = ['aprovar', 'negar'];
        if (!in_array($acao, $acoesPermitidas, true)) {
            throw new InvalidArgumentException("Ação inválida: $acao");
        }

        $novoStatus = $acao === 'aprovar' ? 'aprovado' : 'negado';

        $sql = self::$sql['processar_solicitacao'];
        $comandoExecutar = $pdo->prepare($sql);
        $comandoExecutar->execute(['novo_status' => $novoStatus, 'id' => $idSolicitacao]);

        if ($comandoExecutar->rowCount() === 0) {
            throw new Exception('Solicitação não encontrada ou já processada!');
        }
        return true;
    }

    public static function ultimaSolicitacaoPorPerfil(int $idPerfil)
    {
        global $pdo;
        self::carregarSQL();

        $sql = self::$sql['ultima_solicitacao_por_perfil'];
        $comandoExecutar = $pdo->prepare($sql);
        $comandoExecutar->execute(['id_perfil' => $idPerfil]);

        return $comandoExecutar->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public static function listarTodasSolicitacoes(){
        global $pdo;
        self::carregarSQL();

        $sql = self::$sql['listar_todos'];
        $consulta = $pdo->query($sql);
        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }
}
