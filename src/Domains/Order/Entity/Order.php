<?php

declare(strict_types=1);

namespace App\Domains\Order\Entity;

use App\Domains\Order\Interface\OrderInterface;

class Order implements OrderInterface
{
    public function __construct(
        protected int $id,
        protected float $total,
        protected int $currencyId,
        protected string $createdAt
    ) {}

    public function getId(): int
    {
        return $this->id;
    }

    public function getTotal(): float
    {
        return $this->total;
    }

    public function getCurrencyId(): int
    {
        return $this->currencyId;
    }

    public function getCreationDate(): string
    {
        return $this->createdAt;
    }
}
