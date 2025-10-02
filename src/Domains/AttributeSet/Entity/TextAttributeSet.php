<?php

declare(strict_types=1);

namespace App\Domains\AttributeSet\Entity;

use App\Domains\AttributeSet\Enum\AttributeSetEnum;
use App\Domains\AttributeSet\Entity\AttributeSet;

class TextAttributeSet extends AttributeSet
{
    public function __construct(string $id, string $name)
    {
        parent::__construct($id, $name, AttributeSetEnum::TEXT);
    }
}
