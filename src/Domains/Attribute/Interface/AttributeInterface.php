<?php

declare(strict_types=1);

namespace App\Domains\Attribute\Interface;

interface AttributeInterface
{
    /**
     * Get the ID of an Attribute
     * @return string
     */
    public function getId(): string;

    /**
     * Get the VALUE of an Attribute
     * ex: text, swatch
     * @return string
     */
    public function getValue(): string;

    /**
     * Get the DISPLAY-VALUE of an Attribute for the UI
     * ex: Capacity, Color, Size....
     * @return string
     */
    public function getDisplayValue(): string;

    /**
     * Get the ATTRIBUTE-SET-ID this attribute is related to
     * @return string
     */
    public function getAttributeSetId(): string;
}
