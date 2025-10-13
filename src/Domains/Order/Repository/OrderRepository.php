<?php

declare(strict_types=1);

namespace App\Domains\Order\Repository;

use PDOException;

use App\Core\Logger\LoggerLevelsEnum;
use App\Core\Logger\Logger;

use App\Core\Repository\BaseRepository;
use App\Exceptions\DatabaseException;

class OrderRepository extends BaseRepository
{
    public function createOrder(float $total, int $currencyId): int
    {
        try {
            $query = "INSERT INTO orders (total, currency_id) VALUES (:total, :currencyId)";

            $stmt = $this->connection->prepare($query);

            $stmt->execute([
                "total" => $total,
                "currencyId" => $currencyId
            ]);

            return (int) $this->connection->lastInsertId();
        } catch (PDOException $e) {
            Logger::log("Failed to INSERT an order: {$e->getMessage()}", LoggerLevelsEnum::ERROR);

            throw new DatabaseException("Failed to place an order, please try again");
        }
    }
}
