<?php

declare(strict_types=1);

namespace App\Domains\Product\Repository;

use App\Core\Repository\BaseRepository;

class ProductRepository extends BaseRepository
{
    public function findById(string $id)
    {
        $query = "SELECT * FROM product WHERE id = :id LIMIT 1";

        $stmt = $this->connection->prepare($query);

        $stmt->execute(["id" => $id]);

        return $stmt->fetch();
    }

    public function findByCategoryIds(array $ids): array
    {

        $placeholder = join(",", array_pad([], count($ids), "?"));

        $query = "SELECT * FROM product WHERE category_id IN ({$placeholder})";

        $stmt = $this->connection->prepare($query);

        $stmt->execute($ids);

        return $stmt->fetchAll();
    }

    public function findAll(): array
    {
        $query = "SELECT * FROM product";

        $stmt = $this->connection->prepare($query);

        $stmt->execute();

        return $stmt->fetchAll();
    }
}
