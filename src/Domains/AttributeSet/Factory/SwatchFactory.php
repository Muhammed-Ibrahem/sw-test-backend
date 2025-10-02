<?php

declare(strict_types=1);

namespace App\Domains\AttributeSet\Factory;

use App\Domains\AttributeSet\Interface\AttributeSetInterface;
use App\Domains\AttributeSet\Entity\SwatchAttributeSet;

class SwatchFactory extends AttributeSetFactory
{
    public function createAttributeSet(string $id, string $name): AttributeSetInterface
    {
        return new SwatchAttributeSet($id, $name);
    }
}
