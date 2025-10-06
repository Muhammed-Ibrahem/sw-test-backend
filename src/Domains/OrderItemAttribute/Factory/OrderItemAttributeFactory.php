<?php

declare(strict_types=1);

namespace App\Domains\OrderItemAttribute\Factory;

use App\Domains\OrderItemAttribute\Interface\OrderItemAttributeInterface;
use App\Domains\OrderItemAttribute\Entity\OrderItemAttribute;

class OrderItemAttributeFactory
{
    public static function createOrderItemAttribute(
        int $orderItemId,
        string $attributeId,
        string $attributeSetId
    ): OrderItemAttributeInterface {
        return new OrderItemAttribute($orderItemId, $attributeId, $attributeSetId);
    }
}
