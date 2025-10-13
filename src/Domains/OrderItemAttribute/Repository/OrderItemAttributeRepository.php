<?php

declare(strict_types=1);

namespace App\Domains\OrderItemAttribute\Repository;

use PDOException;

use App\Core\Repository\BaseRepository;
use App\Exceptions\DatabaseException;

class OrderItemAttributeRepository extends BaseRepository
{
    public function createOrderItemAttribute(
        int $orderItemId,
        string $attributeId,
        string $attributeSetId
    ): void {
        try {
            $query =
                "INSERT INTO order_item_attribute (order_item_id, attribute_id, attribute_set_id)
            VALUES (:orderItemId, :attributeId, :attributeSetId)";

            $stmt = $this->connection->prepare($query);

            $stmt->execute([
                "orderItemId" => $orderItemId,
                "attributeId" => $attributeId,
                "attributeSetId" => $attributeSetId
            ]);
        } catch (PDOException $e) {
            throw new DatabaseException();
        }
    }
}
