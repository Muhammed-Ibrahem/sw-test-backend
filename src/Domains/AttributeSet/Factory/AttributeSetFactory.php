<?php

declare(strict_types=1);

namespace App\Domains\AttributeSet\Factory;

use App\Domains\AttributeSet\Interface\AttributeSetInterface;

abstract class AttributeSetFactory
{
    abstract public function createAttributeSet(
        string $id,
        string $name
    ): AttributeSetInterface;
}
