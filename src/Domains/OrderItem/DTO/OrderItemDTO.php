<?php

declare(strict_types=1);

namespace App\Domains\OrderItem\DTO;

use App\Domains\OrderItemAttribute\DTO\OrderItemAttributeDTO;

final class OrderItemDTO
{
    private readonly string $productId;

    private readonly int $quantity;

    private readonly float $unitPrice;

    private readonly int $currencyId;

    /** @var OrderItemAttributeDTO[] */
    private readonly array $attributes;

    public function __construct(
        string $productId,
        int $quantity,
        float $unitPrice,
        int $currencyId,
        array $attributes
    ) {
        $this->setProductId($productId);
        $this->setQuantity($quantity);
        $this->setUnitPrice($unitPrice);
        $this->setCurrencyId($currencyId);
        $this->setAttributes($attributes);
    }

    private function setProductId(string $productId)
    {
        if (empty($productId)) {
            throw new \InvalidArgumentException("ProductId is a required field", 400);
        }
        $this->productId = $productId;
    }

    private function setQuantity(int $quantity)
    {
        if ($quantity <= 0) {
            throw new \InvalidArgumentException("Quantity must be greater than 0.", 400);
        }
        $this->quantity = $quantity;
    }

    private function setUnitPrice(float $unitPrice)
    {
        if ($unitPrice < 0) {
            throw new \InvalidArgumentException("Unit price cannot be negative.", 400);
        }
        $this->unitPrice = $unitPrice;
    }

    private function setCurrencyId(int $currencyId)
    {
        if ($currencyId <= 0) {
            throw new \InvalidArgumentException("Invalid CurrencyId", 400);
        }
        $this->currencyId = $currencyId;
    }

    /** @param OrderItemAttributeDTO[] */
    private function setAttributes(array $attrs)
    {

        foreach ($attrs as $attr) {
            if (! $attr instanceof OrderItemAttributeDTO) {
                throw new \InvalidArgumentException("Invalid Attributes");
            }
        }
        $this->attributes = $attrs;
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

    /** @return OrderItemAttributeDTO[] */
    public function getAttributes(): array
    {
        return $this->attributes;
    }
}
