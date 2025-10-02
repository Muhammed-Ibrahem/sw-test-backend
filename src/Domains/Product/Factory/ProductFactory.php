<?php

declare(strict_types=1);

namespace App\Domains\Product\Factory;

use App\Domains\Product\Entity\Product;
use App\Domains\Product\Interface\ProductInterface;

class ProductFactory
{
    public static function createProduct(
        string $id,
        string $name,
        bool $inStock,
        string $description,
        int $categoryId,
        int $brandId
    ): ProductInterface {
        return new Product($id, $name, $inStock, $description, $categoryId, $brandId);
    }
}
