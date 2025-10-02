<?php

declare(strict_types=1);

namespace App\Domains\Price\Interface;

interface PriceInterface
{
    /**
     * Get the ID of a price
     * @return int
     */
    public function getId(): int;

    /**
     * Get the total amount of a price for a specific product
     * @return float
     */
    public function getAmount(): float;

    /**
     * Get the PRODUCT-ID related to that specific price
     * @return string
     */
    public function getProductId(): string;

    /**
     * Get the CURRENCY-ID related to that specifc price
     * @return int
     */
    public function getCurrencyId(): int;
}
