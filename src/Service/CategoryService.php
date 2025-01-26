<?php

declare(strict_types=1);

namespace App\Service;

use App\CategoryGenerator;
use App\CategoryInserter;
use App\CategoryRetriever;
use PDO;

/**
 * Provide service for manipulating with categories representation
 */
class CategoryService implements ServiceInterface {

    /**
     * @param PDO $pdo
     */
    public function __construct(private readonly PDO $pdo)
    {
    }

    /**
     * Generate data
     * @return CategoryGenerator
     */
    public function generateData(): CategoryGenerator
    {
        $inserter = new CategoryInserter($this->pdo);
        return new CategoryGenerator($inserter);
    }

    /**
     * Make an insert
     * @return void
     */
    public function insertData(): void
    {
        $generator = $this->generateData();
        $generator->insertData();
    }

    /**
     * Retrieve recursive category tree
     * @return array
     */
    public function getData(): array
    {
        $retriever = new CategoryRetriever($this->pdo);
        return $retriever->getCategoryTree();
    }

    /**
     * Prepare the category tree
     * @param array $data
     * @param string $parentId
     * @return array
     */
    public function formatData(array $data, string $parentId = '0'): array
    {
        $result = [];
        foreach ($data as $item) {
            if ($item['parent_id'] === $parentId) {
                $children = $this->formatData($data, $item['group_id']);
                $node = [];
                if (!empty($children)) {
                    $node['_children'] = $children;
                }
                $node['group_id'] = $item['group_id'];
                $node['parent_id'] = $item['parent_id'];
                $node['name'] = $item['name'];

                $result[$item['group_id']] = $node;
            }
        }

        return $result;
    }

    /**
     * @return string
     */
    public function execute(): void
    {
        $this->generateData();
        $this->insertData();
    }

    /**
     * @return string
     */
    public function print(): string
    {
        $data = $this->formatData($this->getData());
        return json_encode($data, JSON_PRETTY_PRINT);
    }
}
