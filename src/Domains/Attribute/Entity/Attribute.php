<?php

declare(strict_types=1);

namespace App\Domains\Attribute\Entity;

use App\Domains\Attribute\Interface\AttributeInterface;

class Attribute implements AttributeInterface
{
    public function __construct(
        protected string $id,
        protected string $displayValue,
        protected string $value,
        protected string $attributeSetId
    ) {}

    public function getId(): string
    {
        return $this->id;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getDisplayValue(): string
    {
        return $this->displayValue;
    }

    public function getAttributeSetId(): string
    {
        return $this->attributeSetId;
    }
}
