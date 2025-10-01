<?php

declare(strict_types=1);

namespace App\Domains\Gallery\Repository;

use App\Core\Repository\BaseRepository;

class GalleryRepository extends BaseRepository
{
    public function findGalleryByProductIds(array $ids): array
    {
        if (empty($ids)) return [];

        $placeholder = join(",", \array_pad([], count($ids), "?"));

        $query = "SELECT * FROM gallery WHERE product_id IN ({$placeholder})";

        $stmt = $this->connection->prepare($query);

        $stmt->execute($ids);

        return $stmt->fetchAll();
    }
}
