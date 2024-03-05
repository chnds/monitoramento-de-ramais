<?php
class RamaisSeeder
{
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function seed(): void
    {
        $exemplos_ramais = [
            ['7000/7000', '181.219.125.7', 'D', 'N', 'ACL', 42367, 'OK (33 ms)'],
            ['7001/7001', '181.219.125.7', 'D', 'N', 'ACL', 42368, 'OK (20 ms)'],
            ['7004/7002', 'Unspecified', 'D', 'N', 'ACL', 0, 'UNKNOWN'],
            ['7003/7003', 'Unspecified', 'D', 'N', 'ACL', 0, 'UNKNOWN'],
            ['7002/7004', '181.219.125.7', 'D', 'N', 'ACL', 42369, 'OK (15 ms)'],
        ];

        $stmt = $this->pdo->prepare("INSERT INTO ramais (Name_username, Host, Dyn, Nat, ACL, Port, Status) VALUES (?, ?, ?, ?, ?, ?, ?)");

        foreach ($exemplos_ramais as $exemplo) {
            $stmt->execute($exemplo);
        }
    }
}