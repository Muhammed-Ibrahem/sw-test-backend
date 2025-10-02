<?php

declare(strict_types=1);

namespace App\GraphQL\Resolvers;

use GraphQL\Deferred;

use App\GraphQL\DataLoader\AttributeLoader;

class AttributeResolver
{
    public function __construct(
        private AttributeLoader $attrLoader
    ) {}

    public function loadAttributes(array $parent): Deferred
    {
        // $productId = $parent['productid'];
        $attrSetId = $parent['attributeSet']->getId();

        $this->attrLoader->loadProductIds($parent['productId']);
        $this->attrLoader->loadSetIds($parent['attributeSet']->getId());

        return new Deferred(function () use ($parent) {
            $this->attrLoader->loadBuffered();

            $attrSets = $this->attrLoader->getValue($parent['productId']);
            $attributesForSet = $attrSets[$parent['attributeSet']->getId()] ?? [];

            return $attributesForSet;
        });
    }
}
