<?php

declare(strict_types=1);

namespace App\Domains\OrderItem\Repository;

use PDOException;

use App\Core\Repository\BaseRepository;
use App\Exceptions\DatabaseException;

class OrderItemRepository extends BaseRepository
{
    public function createOrderItem(
        int $orderId,
        string $productId,
        int $quantity,
        float $unitPrice,
        int $currencyId
    ): int {
        try {
            $query =
                "INSERT INTO order_item (order_id, product_id, quantity, unit_price, currency_id)
            VALUES (:orderId, :productId, :quantity, :unitPrice, :currencyId)";

            $stmt = $this->connection->prepare($query);

            $stmt->execute([
                "orderId" => $orderId,
                "productId" => $productId,
                "quantity" => $quantity,
                "unitPrice" => $unitPrice,
                "currencyId" => $currencyId
            ]);

            return (int) $this->connection->lastInsertId();
        } catch (PDOException $e) {
            throw new DatabaseException();
        }
    }
}
