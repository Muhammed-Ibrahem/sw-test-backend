<?php

declare(strict_types=1);

namespace App\Domains\Category\Repository;

use App\Core\Repository\BaseRepository;
use App\Exceptions\DatabaseException;

use PDOException;

final class CategoryRepository extends BaseRepository
{
    public function getAll(): array
    {
        try {
            $query = "SELECT * FROM category";

            $stmt = $this->connection->prepare($query);

            $stmt->execute();

            return $stmt->fetchAll();
        } catch (PDOException $e) {
            throw new DatabaseException();
        }
    }

    public function findByIds(array $categoryIds): array
    {
        try {
            if (empty($categoryIds)) return [];

            $placeholder = join(",", \array_pad([], \count($categoryIds), "?"));

            $query = "SELECT * FROM category WHERE id IN ({$placeholder})";

            $stmt = $this->connection->prepare($query);

            $stmt->execute($categoryIds);

            return $stmt->fetchAll();
        } catch (PDOException $e) {
            throw new DatabaseException();
        }
    }

    public function findByName(string $categoryName)
    {
        try {
            $query = "SELECT * FROM category WHERE name = :categoryName";

            $stmt = $this->connection->prepare($query);

            $stmt->execute(["categoryName" => $categoryName]);

            return $stmt->fetch();
        } catch (PDOException $e) {
            throw new DatabaseException();
        }
    }
}
