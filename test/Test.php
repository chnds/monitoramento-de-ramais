<?php


require_once 'config.php';

try {
    $pdo = new PDO("mysql:host={$dbHost};dbname={$dbName}", $dbUser, $dbPassword);
    echo "Conexão com o banco de dados estabelecida com sucesso!\n";
} catch (PDOException $e) {
    echo "Erro ao conectar ao banco de dados: " . $e->getMessage() . "\n";
}

$url = 'http://localhost/listarFilas';

// Faça uma requisição HTTP GET para a rota listarFilas
$resultado = file_get_contents($url);

// Verifique se a requisição foi bem-sucedida
if ($resultado !== false) {
    echo "A requisição para listarFilas foi bem-sucedida!\n";
    echo "Resposta: " . $resultado . "\n";
} else {
    echo "Erro ao fazer a requisição para listarFilas!\n";
}
