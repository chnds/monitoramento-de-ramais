<?php

class DataBaseSeeder
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function seed()
    {
        try {
            $this->createTablesIfNotExist();
        } catch (PDOException $e) {
            echo "Erro ao executar seed: " . $e->getMessage();
        }
    }

    private function createTablesIfNotExist()
    {
        $this->createTableRamais();
        $this->createTableFilas();
    }

    private function createTableRamais()
    {
        $stmt = $this->pdo->prepare("SHOW TABLES LIKE 'ramais'");
        $stmt->execute();
        $tableExists = $stmt->rowCount() > 0;

        if (!$tableExists) {
            $this->executeSqlFile('db/create_table_ramais.sql');
            echo "Tabela 'ramais' criada com sucesso\n";
        }
    }

    private function createTableFilas()
    {
        $stmt = $this->pdo->prepare("SHOW TABLES LIKE 'filas'");
        $stmt->execute();
        $tableExists = $stmt->rowCount() > 0;

        if (!$tableExists) {
            $this->executeSqlFile('db/create_table_filas.sql');
            echo "Tabela 'filas' criada com sucesso\n";
        }
    }

    private function executeSqlFile($filename)
    {
        $sql = file_get_contents($filename);
        $this->pdo->exec($sql);
    }
}
