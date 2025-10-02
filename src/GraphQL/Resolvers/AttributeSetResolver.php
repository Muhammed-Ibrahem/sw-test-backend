<?php

declare(strict_types=1);

namespace App\GraphQL\Resolvers;

use GraphQL\Deferred;

use App\Domains\Product\Interface\ProductInterface;
use App\GraphQL\DataLoader\AttributeSetLoader;

class AttributeSetResolver
{
    public function __construct(
        private AttributeSetLoader $attrSetLoader
    ) {}

    public function loadProductAttributeSets(ProductInterface $product): Deferred
    {
        $this->attrSetLoader->load($product->getId());

        return new Deferred(function () use ($product) {
            $this->attrSetLoader->loadBuffered();

            $attributeSetForThisProduct = $this->attrSetLoader->getValue($product->getId());

            $result = [];

            foreach ($attributeSetForThisProduct as $set) {
                $result[] = [
                    'attributeSet' => $set,
                    'productId' => $product->getId()
                ];
            }

            return $result;
        });
    }
}
