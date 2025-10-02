<?php

declare(strict_types=1);

namespace App\Domains\Currency\Repository;

use App\Core\Repository\BaseRepository;

class CurrencyRepository extends BaseRepository
{
    public function findByIds(array $ids): array
    {
        $placeholder = \join(",", \array_pad([], \count($ids), "?"));

        $query = "SELECT * FROM currency WHERE id IN ({$placeholder})";

        $stmt = $this->connection->prepare($query);

        $stmt->execute($ids);

        return $stmt->fetchAll();
    }
}
