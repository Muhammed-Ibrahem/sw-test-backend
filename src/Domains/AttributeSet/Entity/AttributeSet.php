<?php

declare(strict_types=1);

namespace App\Domains\AttributeSet\Entity;

use App\Domains\AttributeSet\Enum\AttributeSetEnum;
use App\Domains\AttributeSet\Interface\AttributeSetInterface;

abstract class AttributeSet implements AttributeSetInterface
{
    public function __construct(
        protected string $id,
        protected string $name,
        protected AttributeSetEnum $type
    ) {}

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): string
    {
        return $this->type->value;
    }
}
