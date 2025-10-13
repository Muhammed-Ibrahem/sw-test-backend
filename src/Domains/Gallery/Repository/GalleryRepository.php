<?php

declare(strict_types=1);

namespace App\Domains\Gallery\Repository;

use PDOException;

use App\Core\Repository\BaseRepository;
use App\Exceptions\DatabaseException;

class GalleryRepository extends BaseRepository
{
    public function findGalleryByProductIds(array $ids): array
    {
        try {
            if (empty($ids)) return [];

            $placeholder = join(",", \array_pad([], count($ids), "?"));

            $query = "SELECT * FROM gallery WHERE product_id IN ({$placeholder})";

            $stmt = $this->connection->prepare($query);

            $stmt->execute($ids);

            return $stmt->fetchAll();
        } catch (PDOException $e) {
            throw new DatabaseException();
        }
    }
}
