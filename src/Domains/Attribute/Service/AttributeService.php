<?php

declare(strict_types=1);

namespace App\Domains\Attribute\Service;

use App\Domains\Attribute\Repository\AttributeRepository;
use App\Domains\Attribute\Factory\AttributeFactory;

class AttributeService
{
    public function __construct(
        private AttributeRepository $repo
    ) {}

    public function getAttrByProductAndSetIds(array $productIds, array $setIds)
    {

        $rows = $this->repo->findByProductAndSetIds($productIds, $setIds);

        $attributes = $this->createAttributeGroupedByProductAndSetId($rows);

        return $attributes;
    }

    private function createAttributeFromDBRow(array $row)
    {
        $id = $row['id'];
        $displayValue = $row['display_value'];
        $value = $row['value'];
        $attrSetId = $row['attribute_set_id'];

        return AttributeFactory::createAttribute($id, $displayValue, $value, $attrSetId);
    }

    private function createAttributeGroupedByProductAndSetId(array $rows)
    {
        $groupedAttributes = [];

        foreach ($rows as $row) {
            $groupedAttributes[$row['product_id']][$row["attribute_set_id"]][] = $this->createAttributeFromDBRow($row);
        }

        return $groupedAttributes;
    }
}
