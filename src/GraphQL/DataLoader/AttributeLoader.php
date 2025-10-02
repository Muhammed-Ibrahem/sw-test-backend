<?php

declare(strict_types=1);

namespace App\GraphQL\DataLoader;

use App\Domains\Attribute\Service\AttributeService;

class AttributeLoader
{
    private array $productIds = [];

    private array $setIds = [];

    private array $bufferedAttributes = [];
    public function __construct(private AttributeService $attributeService) {}

    public function loadProductIds(string $prodId)
    {
        $this->productIds[$prodId] = $prodId;
    }

    public function loadSetIds(string $setId)
    {
        $this->setIds[$setId] = $setId;
    }

    public function loadBuffered(): void
    {
        if (empty($this->productIds) || empty($this->setIds)) {
            return;
        }

        $prodIdsToLoad = \array_values($this->productIds);
        $setIdsToLoad = \array_values($this->setIds);

        $this->bufferedAttributes = $this->attributeService->getAttrByProductAndSetIds($prodIdsToLoad, $setIdsToLoad);

        $this->productIds = [];
        $this->setIds = [];
    }

    public function getValue(string $productId)
    {
        return $this->bufferedAttributes[$productId];
    }
}
