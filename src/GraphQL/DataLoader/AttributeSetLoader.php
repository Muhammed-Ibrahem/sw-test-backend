<?php

namespace App\GraphQL\DataLoader;

use App\Domains\AttributeSet\Service\AttributeSetService;

class AttributeSetLoader extends Loader
{
    public function __construct(private AttributeSetService $attributeSetService) {}

    public function loadBuffered(): void
    {
        $this->loadBatch([$this->attributeSetService, 'getAttributeSetByProductIds']);
    }
}
