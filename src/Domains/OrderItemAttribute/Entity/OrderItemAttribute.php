<?php

declare(strict_types=1);

namespace App\Domains\OrderItemAttribute\Entity;

use App\Domains\OrderItemAttribute\Interface\OrderItemAttributeInterface;


class OrderItemAttribute implements OrderItemAttributeInterface
{
    public function __construct(
        protected int $orderItemId,
        protected string $attributeId,
        protected string $attributeSetId
    ) {}

    public function getOrderItemId(): int
    {
        return $this->orderItemId;
    }

    public function getAttributeId(): string
    {
        return $this->attributeId;
    }

    public function getAttributeSetId(): string
    {
        return $this->attributeSetId;
    }
}
