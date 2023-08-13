<?php

namespace App\Database;

class Database
{
    private $pdo;

    public function __construct()
    {
        try {
            //for a more vast version of this project add the dbs here 
            $dbPath = __DIR__ . '/../../storage/travel.db';
            $this->pdo = new \PDO("sqlite:$dbPath");
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->initTables();
        } catch (\PDOException $e) {
            throw new \Exception("Database connection failed: " . $e->getMessage(), 500);
        }
    }

 
    private function initTables(): void
    {
       
        $this->pdo->exec("
            CREATE TABLE IF NOT EXISTS cache (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                key TEXT UNIQUE,
                data TEXT,
                expires_at DATETIME
            )
        ");

      
        $this->pdo->exec("
            CREATE TABLE IF NOT EXISTS search_history (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                destination TEXT,
                user_id TEXT,
                timestamp DATETIME
            )
        ");
    }

 
    public function getPdo(): \PDO
    {
        return $this->pdo;
    }
}
?>