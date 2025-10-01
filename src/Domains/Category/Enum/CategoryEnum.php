<?php

declare(strict_types=1);

namespace App\Domains\Category\Enum;

use App\Domains\Category\Factory\AllCategoryFactory;
use App\Domains\Category\Factory\CategoryFactory;
use App\Domains\Category\Factory\ClothesFactory;
use App\Domains\Category\Factory\TechFactory;

enum CategoryEnum: string
{
    case All = "all";

    case Tech = "tech";

    case Clothes = "clothes";

    public function getFactory(): CategoryFactory
    {
        return match ($this) {
            self::All => new AllCategoryFactory(),
            self::Tech => new TechFactory(),
            self::Clothes => new ClothesFactory()
        };
    }
}
