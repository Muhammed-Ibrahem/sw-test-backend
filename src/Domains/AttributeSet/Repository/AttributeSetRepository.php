<?php

declare(strict_types=1);

namespace App\Domains\AttributeSet\Repository;

use App\Core\Repository\BaseRepository;

class AttributeSetRepository extends BaseRepository
{
    public function findByProductIds(array $productIds)
    {
        $placeholder = \join(",", \array_pad([], \count($productIds), "?"));

        $query =
            "SELECT DISTINCT ATS.*, PA.product_id
            FROM attribute_set AS ATS
            JOIN product_attribute AS PA ON PA.attribute_set_id = ATS.id
            WHERE PA.product_id IN ({$placeholder})";

        $stmt = $this->connection->prepare($query);

        $stmt->execute($productIds);

        return $stmt->fetchAll();
    }
}
