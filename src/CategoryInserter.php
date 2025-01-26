<?php

declare(strict_types=1);

namespace App;

use App\Repository\CategoryRepository;
use PDO;

/**
 * Prepare data to insert into DB
 */
class CategoryInserter {
    private PDO $pdo;

    /**
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @param array $categories
     * @return void
     */
    public function batchInsertCategories(array $categories): void
    {
        if (empty($categories)) {
            return;
        }

        $queryData = $this->prepareBatchInsertQuery($categories);
        $repository = new CategoryRepository($this->pdo);
        $repository->insert($queryData['query'], $queryData['values']);
    }

    /**
     * @param $categories
     * @return array
     */
    public function prepareBatchInsertQuery($categories): array
    {
        $placeholders = [];
        $values = [];

        foreach ($categories as $category) {
            $placeholders[] = "(?, ?, ?)";
            $values[] = $category['group_id'];
            $values[] = $category['parent_id'];
            $values[] = $category['name'];
        }

        $query = "INSERT INTO categories (group_id, parent_id, name) VALUES " . implode(", ", $placeholders);

        return [
            'query' => $query,
            'values' => $values
        ];
    }
}
