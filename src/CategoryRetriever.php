<?php

declare(strict_types=1);

namespace App;

use App\Repository\CategoryRepository;
use PDO;

/**
 * Prepare query and get the categories
 */
class CategoryRetriever
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getCategoryTree(): array
    {
        $query = "
            WITH RECURSIVE cat AS (
            SELECT 
                group_id,
                name,
                parent_id
            FROM categories
            WHERE parent_id = '0'
            UNION ALL
            SELECT 
                t.group_id,
                t.name,
                t.parent_id
            FROM categories t
            INNER JOIN cat ON t.parent_id = cat.group_id
        )
        SELECT * FROM cat limit 100"
        ;

        return $this->fetchCategories($query);
    }

    public function fetchCategories(string $query): array
    {
        $repository = new CategoryRepository($this->pdo);
        return $repository->get($query);
    }
}