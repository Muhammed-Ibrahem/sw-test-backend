<?php

declare(strict_types=1);

namespace App\Domains\AttributeSet\Enum;

use App\Domains\AttributeSet\Factory\AttributeSetFactory;
use App\Domains\AttributeSet\Factory\SwatchFactory;
use App\Domains\AttributeSet\Factory\TextFactory;

enum AttributeSetEnum: string
{
    case TEXT = "text";

    case SWATCH = "swatch";

    public function getFactory(): AttributeSetFactory
    {
        return match ($this) {
            self::TEXT => new TextFactory(),
            self::SWATCH => new SwatchFactory()
        };
    }
}
