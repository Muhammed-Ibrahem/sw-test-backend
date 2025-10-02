<?php

declare(strict_types=1);

namespace App\Domains\Currency\Interface;

interface CurrencyInterface
{
    /**
     * Get the ID of a currency
     * @return int
     */
    public function getId(): int;

    /**
     * Get the LABEL of a currency
     * example: "USD", "EGP"...
     * @return string
     */
    public function getLabel(): string;

    /**
     * Get the SYMBOL of a currency
     * example: "$"
     * @return string
     */
    public function getSymbol(): string;
}
