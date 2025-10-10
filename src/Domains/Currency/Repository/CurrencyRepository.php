<?php

declare(strict_types=1);

namespace App\Domains\Currency\Repository;

use PDOException;

use App\Core\Repository\BaseRepository;
use App\Exceptions\DatabaseException;

class CurrencyRepository extends BaseRepository
{
    public function findByIds(array $ids): array
    {
        try {
            $placeholder = \join(",", \array_pad([], \count($ids), "?"));

            $query = "SELECT * FROM currency WHERE id IN ({$placeholder})";

            $stmt = $this->connection->prepare($query);

            $stmt->execute($ids);

            return $stmt->fetchAll();
        } catch (PDOException $e) {
            throw new DatabaseException();
        }
    }
}
