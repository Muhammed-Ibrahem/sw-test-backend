<?php

declare(strict_types=1);

namespace App\Domains\Brand\Factory;

use App\Domains\Brand\Entity\Brand;

class BrandFactory
{
    public static function createBrand(int $id, string $name)
    {
        return new Brand($id, $name);
    }
}
