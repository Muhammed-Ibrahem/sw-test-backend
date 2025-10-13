<?php

declare(strict_types=1);

namespace App\Domains\Product\Repository;

use PDOException;

use App\Core\Repository\BaseRepository;
use App\Exceptions\DatabaseException;

class ProductRepository extends BaseRepository
{
    public function findById(string $id)
    {
        try {
            $query = "SELECT * FROM product WHERE id = :id LIMIT 1";

            $stmt = $this->connection->prepare($query);

            $stmt->execute(["id" => $id]);

            return $stmt->fetch();
        } catch (PDOException $e) {
            throw new DatabaseException();
        }
    }

    public function findByCategoryIds(array $ids): array
    {

        try {
            $placeholder = join(",", array_pad([], count($ids), "?"));

            $query = "SELECT * FROM product WHERE category_id IN ({$placeholder})";

            $stmt = $this->connection->prepare($query);

            $stmt->execute($ids);

            return $stmt->fetchAll();
        } catch (PDOException $e) {
            throw new DatabaseException();
        }
    }

    public function findAll(): array
    {
        try {
            $query = "SELECT * FROM product";

            $stmt = $this->connection->prepare($query);

            $stmt->execute();

            return $stmt->fetchAll();
        } catch (PDOException $e) {
            throw new DatabaseException();
        }
    }
}
