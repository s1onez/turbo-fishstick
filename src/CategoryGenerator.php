<?php

declare(strict_types=1);

namespace App;

/**
 * Generate insert data for categories table
 */
class CategoryGenerator {
    private CategoryInserter $inserter;
    private int $totalRecords;
    private int $groupIdCounter = 1;
    private array $categories = [];

    /**
     * @param CategoryInserter $inserter
     * @param int $totalRecords
     */
    public function __construct(CategoryInserter $inserter, int $totalRecords = 11000)
    {
        $this->inserter = $inserter;
        $this->totalRecords = $totalRecords;
    }

    /**
     * @param string $groupId
     * @param string $parentId
     * @param string $name
     * @return void
     */
    private function addCategoryToBatch(string $groupId, string $parentId, string $name): void
    {
        $this->categories[] = [
            'group_id' => $groupId,
            'parent_id' => $parentId,
            'name' => $name
        ];
    }

    /**
     * @param string $parentId
     * @param int $currentLevel
     * @param int $maxLevels
     * @return void
     */
    public function generateSubLevels(string $parentId, int $currentLevel, int $maxLevels): void
    {
        if ($this->groupIdCounter > $this->totalRecords || $currentLevel > $maxLevels) {
            return;
        }

        $subLevelCount = rand(1, 10);
        for ($i = 1; $i <= $subLevelCount; $i++) {
            $groupId = $parentId . "_" . $i;
            $this->addCategoryToBatch($groupId, $parentId, "Group " . $groupId);
            $this->groupIdCounter++;

            if ($this->groupIdCounter > $this->totalRecords) {
                return;
            }
            $this->generateSubLevels($groupId, $currentLevel + 1, $maxLevels);
        }
    }

    /**
     * Generate random data to fill the table
     * @return void
     */
    public function insertData(): void
    {
        $maxLevels = rand(3, 6);
        $rootCount = rand(5, 15);

        for ($i = 1; $i <= $rootCount; $i++) {
            $groupId = (string)$i;
            $this->addCategoryToBatch($groupId, '0', "Group " . $groupId);
            $this->groupIdCounter++;
            $this->generateSubLevels($groupId, 1, $maxLevels);

            if ($this->groupIdCounter > $this->totalRecords) {
                break;
            }
        }
        $this->inserter->batchInsertCategories($this->categories);
    }
}