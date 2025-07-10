<?php


require_once 'Connection.php';

try {
    $pdo = new PDOConnection();
}catch(PDOException $e) {
    echo 'Erro: '. $e->getMessage();
}