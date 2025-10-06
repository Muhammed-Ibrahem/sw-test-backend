<?php

declare(strict_types=1);

namespace App\Domains\OrderItemAttribute\Interface;

interface OrderItemAttributeInterface
{
    /**
     * Get the ID of a specific item on the order
     * @return int
     */
    public function getOrderItemId(): int;

    /**
     * Get the ID of the attribute that was specified for that item
     *  during order placement
     * @return string
     */
    public function getAttributeId(): string;

    /**
     * Get the ID of the SET that contains a group of attributes
     * @return string
     */
    public function getAttributeSetId(): string;
}
