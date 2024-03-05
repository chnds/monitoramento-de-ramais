<?php

require_once 'seeder/RamaisSeeder.php';
require_once 'seeder/FilasSeeder.php';
$config = require_once 'config.php';

$host = $config['host'];
$dbname = $config['dbname'];
$username = $config['username'];
$password = $config['password'];

try {
    function isLocalhost() {
        return ($_SERVER['REMOTE_ADDR'] === '127.0.0.1' || $_SERVER['REMOTE_ADDR'] === '::1');
    }

    if (isLocalhost()) {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $databaseSeeder = new DataBaseSeeder($pdo);
        $databaseSeeder->seed();

        // Exclua os registros das tabelas de ramais e filas
        $stmtDeleteRamais = $pdo->prepare("DELETE FROM ramais");
        $stmtDeleteRamais->execute();

        $stmtDeleteFilas = $pdo->prepare("DELETE FROM filas");
        $stmtDeleteFilas->execute();

        // Chame os seeders para popular as tabelas de ramais e filas
        $ramaisSeeder = new RamaisSeeder($pdo);
        $ramaisSeeder->seed();

        $filasSeeder = new FilasSeeder($pdo);
        $filasSeeder->seed();
    } else {
        echo "As operações de teste só podem ser executadas no ambiente local.\n";
    }
} catch (PDOException $e) {
    echo "Erro ao executar teste unitário: " . $e->getMessage();
}
