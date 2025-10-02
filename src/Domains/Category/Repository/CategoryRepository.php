<?php

declare(strict_types=1);

namespace App\Domains\Category\Repository;

use App\Core\Repository\BaseRepository;


final class CategoryRepository extends BaseRepository
{
    public function getAll(): array
    {
        $query = "SELECT * FROM category";

        $stmt = $this->connection->prepare($query);

        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function findByIds(array $categoryIds): array
    {
        if (empty($categoryIds)) return [];

        $placeholder = join(",", \array_pad([], \count($categoryIds), "?"));

        $query = "SELECT * FROM category WHERE id IN ({$placeholder})";

        $stmt = $this->connection->prepare($query);

        $stmt->execute($categoryIds);

        return $stmt->fetchAll();
    }
}
