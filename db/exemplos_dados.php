<?php
$config = require_once 'config.php';

function conectarBancoDados($host, $dbname, $username, $password) {
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        echo "Erro ao conectar ao banco de dados: " . $e->getMessage();
        return null;
    }
}

function inserirDadosRamais($pdo, $exemplos_ramais) {
    try {
        $stmt = $pdo->prepare("INSERT INTO ramais (Name_username, Host, Dyn, Nat, ACL, Port, Status) VALUES (?, ?, ?, ?, ?, ?, ?)");

        foreach ($exemplos_ramais as $exemplo) {
            $stmt->execute($exemplo);
        }

        echo "Dados de exemplo para ramais inseridos com sucesso\n";
    } catch (PDOException $e) {
        echo "Erro ao inserir dados de exemplo para ramais: " . $e->getMessage();
    }
}

function inserirDadosFilas($pdo) {
    try {
        $stmt = $pdo->prepare("INSERT INTO filas (nome, ramais, status) VALUES (?, ?, ?)");
        $stmt->execute(['gcallcenter-SUPORTE', 'SIP/7000,SIP/7001,SIP/7002,SIP/7003,SIP/7004', 'ativo']);

        echo "Dados de exemplo para filas inseridos com sucesso\n";
    } catch (PDOException $e) {
        echo "Erro ao inserir dados de exemplo para filas: " . $e->getMessage();
    }
}


$host = $config['host'];
$dbname = $config['dbname'];
$username = $config['username'];
$password = $config['password'];

$pdo = conectarBancoDados($host, $dbname, $username, $password);

if ($pdo !== null) {
    $exemplos_ramais = [
        ['7000/7000', '181.219.125.7', 'D', 'N', 'ACL', 42367, 'OK (33 ms)'],
        ['7001/7001', '181.219.125.7', 'D', 'N', 'ACL', 42368, 'OK (20 ms)'],
        ['7004/7002', 'Unspecified', 'D', 'N', 'ACL', 0, 'UNKNOWN'],
        ['7003/7003', 'Unspecified', 'D', 'N', 'ACL', 0, 'UNKNOWN'],
        ['7002/7004', '181.219.125.7', 'D', 'N', 'ACL', 42369, 'OK (15 ms)'],
    ];

    inserirDadosRamais($pdo, $exemplos_ramais);

    inserirDadosFilas($pdo);
}

?>
