<?php

declare(strict_types=1);

namespace App\Domains\Order\Factory;

use App\Domains\Order\Entity\Order;
use App\Domains\Order\Interface\OrderInterface;

class OrderFactory
{
    public static function createOrder(
        int $id,
        float $total,
        int $currencyId,
        string $createdAt
    ): OrderInterface {
        return new Order($id, $total, $currencyId, $createdAt);
    }
}
