<?php

declare(strict_types=1);

namespace App\Domains\AttributeSet\Service;

use App\Domains\AttributeSet\Repository\AttributeSetRepository;
use App\Domains\AttributeSet\Enum\AttributeSetEnum;

class AttributeSetService
{
    public function __construct(
        private AttributeSetRepository $repo
    ) {}

    public function getAttributeSetByProductIds(array $productIds)
    {
        $rows = $this->repo->findByProductIds($productIds);

        $sets = $this->createAttributeSetGroupedByProductId($rows);


        foreach ($productIds as $id) {
            if (! isset($sets[$id])) {
                $sets[$id] = [];
            }
        }

        return $sets;
    }

    private function createAttributeSetFromDBRow(array $row)
    {
        $id = $row['id'];
        $name = $row['name'];
        $type = $row['type'];

        return AttributeSetEnum::from($type)->getFactory()->createAttributeSet($id, $name);
    }

    private function createAttributeSetGroupedByProductId(array $rows)
    {
        $groupedSets = [];

        foreach ($rows as $row) {
            $groupedSets[$row['product_id']][] = $this->createAttributeSetFromDBRow($row);
        }

        return $groupedSets;
    }
}
