<?php

declare(strict_types=1);

namespace App\Repository;

interface RepositoryInterface {
    public function get(string $query): array;
    public function insert(string $query, array $values): void;
}