<?php

declare(strict_types=1);

namespace App\Domains\AttributeSet\Interface;

interface AttributeSetInterface
{
    /**
     * Get the ID of an AttributeSet
     * @return string
     */
    public function getId(): string;

    /**
     * Get the NAME of an AttributeSet
     * @return string
     */
    public function getName(): string;

    /**
     * Get the TYPE of an AttributeSet
     * @return string
     */
    public function getType(): string;
}
