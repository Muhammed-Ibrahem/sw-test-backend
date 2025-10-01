<?php

declare(strict_types=1);

namespace App\Domains\Brand\Entity;

use App\Domains\Brand\Interface\BrandInterface;

class Brand implements BrandInterface
{
    public function __construct(
        private int $id,
        private string $name
    ) {}

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
