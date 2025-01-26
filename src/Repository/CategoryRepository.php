<?php

declare(strict_types=1);

namespace App\Repository;

use PDO;

readonly class CategoryRepository implements RepositoryInterface {

    public function __construct(private PDO $pdo)
    {
    }
    public function get(string $query): array
    {
        $stmt = $this->pdo->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function insert(string $query, array $values): void
    {
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($values);
    }
}