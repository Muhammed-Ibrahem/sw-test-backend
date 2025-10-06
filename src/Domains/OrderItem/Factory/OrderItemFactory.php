<?php

declare(strict_types=1);

namespace App\Domains\OrderItem\Factory;

use App\Domains\OrderItem\Entity\OrderItem;
use App\Domains\OrderItem\Interface\OrderItemInterface;

class OrderItemFactory
{
    public static function createOrderItem(
        int $id,
        int $orderId,
        string $productId,
        int $quantity,
        float $unitPrice,
        int $currencyId
    ): OrderItemInterface {
        return new OrderItem(
            $id,
            $orderId,
            $productId,
            $quantity,
            $unitPrice,
            $currencyId
        );
    }
}
