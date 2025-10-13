<?php

declare(strict_types=1);

namespace App\Domains\Order\DTO;

use App\Domains\OrderItem\DTO\OrderItemDTO;

class OrderDTO
{
    /** @var OrderItemDTO[] */
    private readonly array $orderItems;

    public function __construct(
        array $orderItems
    ) {
        $this->setOrderItems($orderItems);
    }

    /** @param OrderItemDTO[] */
    private function setOrderItems(array $orderItems)
    {
        if (empty($orderItems)) {
            throw new \InvalidArgumentException("Order must have at least one item.");
        }

        foreach ($orderItems as $item) {
            if (!$item instanceof OrderItemDTO) {
                throw new \InvalidArgumentException("Invalid OrderItems");
            }
        }
        $this->orderItems = $orderItems;
    }

    public function getOrderItems()
    {
        return $this->orderItems;
    }
}
