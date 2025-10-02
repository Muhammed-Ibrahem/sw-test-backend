<?php

declare(strict_types=1);

namespace App\GraphQL\Resolvers;

use GraphQL\Deferred;

use App\Domains\Product\Interface\ProductInterface;
use App\GraphQL\DataLoader\PriceLoader;

class PriceResolver
{
    public function __construct(
        private PriceLoader $priceLoader
    ) {}
    public function loadPriceByProductIds(ProductInterface $product): Deferred
    {
        $this->priceLoader->load($product->getId());

        return new Deferred(function () use ($product) {
            $this->priceLoader->loadBuffered();

            return $this->priceLoader->getValue($product->getId());
        });
    }
}
