<?php

declare(strict_types=1);

namespace App\Domains\OrderItem\Interface;

interface OrderItemInterface
{
    /**
     * Get the ID of the OrderItem
     * @return int
     */
    public function getId(): int;

    /**
     * Get the ID Of the Order
     * @return int
     */
    public function getOrderId(): int;

    /**
     * Get the ID of the Product
     * @return string
     */
    public function getProductId(): string;

    /**
     * Get the Item-Quantity
     * @return int
     */
    public function getQuantity(): int;

    /**
     * Get the UnitPrice AKA => "The price at purchase"
     * @return float
     */
    public function getUnitPrice(): float;

    /**
     * Get the CurrencyId of the item
     * @return int
     */
    public function getCurrencyId(): int;
}
