<?php

declare(strict_types=1);

namespace App\Domains\Price\Repository;

use App\Core\Repository\BaseRepository;

class PriceRepository extends BaseRepository
{
    public function findPriceByProductIds(array $ids): array
    {
        if (empty($ids)) return [];

        $placeholder = \join(",", \array_pad([], \count($ids), "?"));

        $query = "SELECT * FROM price WHERE product_id IN ({$placeholder})";

        $stmt = $this->connection->prepare($query);

        $stmt->execute($ids);

        return $stmt->fetchAll();
    }
}
