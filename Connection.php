<?php

require_once 'env.php';
loadEnv(__DIR__ . '/.env');

class PDOConnection extends PDO
{

    public function __construct()
    {
        $host = getenv('DB_HOST');
        $port = getenv('DB_PORT') ?: '3306';
        $dbname = getenv('DB_NAME');
        $user = getenv('DB_USER');
        $pass = getenv('DB_PASSWORD');

        $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8";

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ];
    
        try {
            parent::__construct($dsn, $user, $pass, $options);
        } catch (PDOException $e) {
            die("Erro na conexão: " . $e->getMessage());
        }
    }
}

$pdo = new PDOConnection();