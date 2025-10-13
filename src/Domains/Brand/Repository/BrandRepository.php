<?php

declare(strict_types=1);

namespace App\Domains\Brand\Repository;

use PDOException;

use App\Core\Logger\LoggerLevelsEnum;
use App\Core\Logger\Logger;

use App\Core\Repository\BaseRepository;
use App\Exceptions\DatabaseException;

class BrandRepository extends BaseRepository
{
    public function findByIds(array $ids): array
    {
        try {
            if (empty($ids)) return [];

            $placeholder = join(",", array_pad([], count($ids), "?"));

            $query = "SELECT * FROM brand WHERE id IN ({$placeholder})";

            $stmt = $this->connection->prepare($query);

            $stmt->execute($ids);

            return $stmt->fetchAll();
        } catch (PDOException $e) {
            Logger::log("Failed to retrieve Brands: {$e->getMessage()}", LoggerLevelsEnum::ERROR);

            throw new DatabaseException();
        }
    }
}
