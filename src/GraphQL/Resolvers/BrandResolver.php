<?php

declare(strict_types=1);

namespace App\GraphQL\Resolvers;

use GraphQL\Deferred;

use App\Domains\Product\Interface\ProductInterface;
use App\GraphQL\DataLoader\BrandLoader;

class BrandResolver
{
    public function __construct(
        private BrandLoader $brandLoader
    ) {}

    public function loadProductBrand(ProductInterface $product): Deferred
    {
        $brandId = $product->getBrandId();
        $this->brandLoader->load($brandId);

        return new Deferred(function () use ($brandId) {
            $this->brandLoader->loadBuffered();

            return $this->brandLoader->getValue($brandId);
        });
    }
}
