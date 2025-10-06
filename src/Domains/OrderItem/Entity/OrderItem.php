<?php

declare(strict_types=1);

namespace App\Domains\OrderItem\Entity;

use App\Domains\OrderItem\Interface\OrderItemInterface;

class OrderItem implements OrderItemInterface
{
    public function __construct(
        protected int $id,
        protected int $orderId,
        protected string $productId,
        protected int $quantity,
        protected float $unitPrice,
        protected int $currencyId,
    ) {}

    public function getId(): int
    {
        return $this->id;
    }
    public function getOrderId(): int
    {
        return $this->orderId;
    }
    public function getProductId(): string
    {
        return $this->productId;
    }
    public function getQuantity(): int
    {
        return $this->quantity;
    }
    public function getUnitPrice(): float
    {
        return $this->unitPrice;
    }
    public function getCurrencyId(): int
    {
        return $this->currencyId;
    }
}
