<?php

declare(strict_types=1);

namespace App\Domains\Category\Repository;

use App\Core\Repository\BaseRepository;


final class CategoryRepository extends BaseRepository
{
    public function getAll(): array
    {
        $query = "SELECT * FROM category";

        $stmt = $this->connection->prepare($query);

        $stmt->execute();

        return $stmt->fetchAll();
    }
}
