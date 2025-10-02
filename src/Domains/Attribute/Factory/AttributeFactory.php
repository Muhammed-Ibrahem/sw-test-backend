<?php

declare(strict_types=1);

namespace App\Domains\Attribute\Factory;

use App\Domains\Attribute\Interface\AttributeInterface;
use App\Domains\Attribute\Entity\Attribute;

class AttributeFactory
{
    public static function createAttribute(
        string $id,
        string $displayValue,
        string $value,
        string $attributeSetId,
    ): AttributeInterface {
        return new Attribute(
            $id,
            $displayValue,
            $value,
            $attributeSetId
        );
    }
}
