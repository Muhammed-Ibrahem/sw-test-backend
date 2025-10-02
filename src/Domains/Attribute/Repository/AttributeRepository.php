<?php

declare(strict_types=1);

namespace App\Domains\Attribute\Repository;

use App\Core\Repository\BaseRepository;

class AttributeRepository extends BaseRepository
{
    public function findByProductAndSetIds(array $productIds, array $setIds): array
    {
        $productIdsPlaceholder = \join(",", \array_pad([], \count($productIds), "?"));
        $setIdsPlaceholder = \join(",", \array_pad([], \count($setIds), "?"));

        $query =
            "SELECT DISTINCT A.*, PA.product_id, ATS.id AS ATSid FROM attribute AS A
            JOIN product_attribute as PA ON PA.attribute_id = A.id
            AND PA.attribute_set_id = A.attribute_set_id
            JOIN attribute_set as ATS ON ATS.id = PA.attribute_set_id
            WHERE PA.product_id IN ({$productIdsPlaceholder})
            AND A.attribute_set_id IN ({$setIdsPlaceholder})";

        $stmt = $this->connection->prepare($query);

        $stmt->execute([...$productIds, ...$setIds]);

        return $stmt->fetchAll();
    }
}
