<?php

namespace App\Models;

use App\Database\Database;

class SearchHistory
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = (new Database())->getPdo();
    }

    public function logSearch(string $destination, ?string $userId = null): void
    {
        $stmt = $this->pdo->prepare('
            INSERT INTO search_history (destination, user_id, timestamp)
            VALUES (?, ?, ?)
        ');
        $stmt->execute([$destination, $userId, date('Y-m-d H:i:s')]);
    }

    public function getRecentSearches(int $limit = 10): array
    {   //this query isnot optimized or fast in any-way one thing to notice with vast amnount we tend to perform indexing of just data
        $stmt = $this->pdo->prepare('
            SELECT destination, user_id, timestamp
            FROM search_history
            ORDER BY timestamp DESC
            LIMIT ?
        ');
        $stmt->execute([$limit]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
?>