<?php

declare(strict_types=1);

namespace App\Domains\Order\Repository;

use App\Core\Repository\BaseRepository;

class OrderRepository extends BaseRepository
{
    public function createOrder(float $total, int $currencyId): int
    {
        $query = "INSERT INTO orders (total, currency_id) VALUES (:total, :currencyId)";

        $stmt = $this->connection->prepare($query);

        $stmt->execute([
            "total" => $total,
            "currencyId" => $currencyId
        ]);

        return (int) $this->connection->lastInsertId();
    }
}
