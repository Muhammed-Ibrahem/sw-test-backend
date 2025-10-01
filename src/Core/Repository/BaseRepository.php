<?php

declare(strict_types=1);

namespace App\Core\Repository;

use PDO;

abstract class BaseRepository
{
    public function __construct(protected PDO $connection) {}
}
