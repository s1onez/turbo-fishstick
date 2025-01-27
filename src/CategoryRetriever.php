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
                SELECT 
                group_id,
                name,
                parent_id
            FROM categories";

        return $this->fetchCategories($query);
    }

    public function fetchCategories(string $query): array
    {
        $repository = new CategoryRepository($this->pdo);
        return $repository->get($query);
    }
}