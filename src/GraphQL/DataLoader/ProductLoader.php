<?php

declare(strict_types=1);

namespace App\GraphQL\DataLoader;

use App\Domains\Product\Service\ProductService;
use App\GraphQL\DataLoader\Loader;

class ProductLoader extends Loader
{
    public function __construct(private ProductService $srv) {}

    public function loadBuffered(): void
    {
        $this->loadBatch([$this->srv, "getProductsByCategoryIds"]);
    }
}
