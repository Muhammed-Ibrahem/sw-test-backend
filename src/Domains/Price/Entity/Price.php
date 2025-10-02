<?php

declare(strict_types=1);

namespace App\Domains\Price\Entity;

use App\Domains\Price\Interface\PriceInterface;

class Price implements PriceInterface
{
    public function __construct(
        private int $id,
        private float $amount,
        private string $productId,
        private int $currencyId
    ) {}

    public function getId(): int
    {
        return $this->id;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getProductId(): string
    {
        return $this->productId;
    }

    public function getCurrencyId(): int
    {
        return $this->currencyId;
    }
}
