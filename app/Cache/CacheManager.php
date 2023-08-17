<?php

namespace App\Cache;

use App\Database\Database;

class CacheManager
{
    private $pdo;
    private $ttl;

    public function __construct()
    {
        $config = require __DIR__ . '/../../config/cache.php';
        $this->ttl = $config['ttl'];
        $this->pdo = (new Database())->getPdo();
    }

    public function get(string $key): ?array
    {
        $stmt = $this->pdo->prepare('SELECT data, expires_at FROM cache WHERE key = ?');
        $stmt->execute([$key]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($result && strtotime($result['expires_at']) > time()) {
            return json_decode($result['data'], true);
        }

        
        $this->delete($key);
        return null;
    }

    public function set(string $key, array $data): void
    {
        $expiresAt = date('Y-m-d H:i:s', time() + $this->ttl);
        $stmt = $this->pdo->prepare('
            INSERT OR REPLACE INTO cache (key, data, expires_at)
            VALUES (?, ?, ?)
        ');
        $stmt->execute([$key, json_encode($data), $expiresAt]);
    }

    
    public function delete(string $key): void
    {
        $stmt = $this->pdo->prepare('DELETE FROM cache WHERE key = ?');
        $stmt->execute([$key]);
    }
}
?>