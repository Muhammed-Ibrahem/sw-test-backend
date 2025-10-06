<?php

declare(strict_types=1);

namespace App\Domains\Order\Interface;

interface OrderInterface
{
    /**
     * Get the ID of the order
     * @return int
     */
    public function getId(): int;

    /**
     * Get the Total-Price of the order
     * @return float
     */
    public function getTotal(): float;

    /**
     * Get the CurrencyID of the order
     * @return int
     */
    public function getCurrencyId(): int;

    /**
     * Get the creation date of the order
     * @return string
     */
    public function getCreationDate(): string;
}
