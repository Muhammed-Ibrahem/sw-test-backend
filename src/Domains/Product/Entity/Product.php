<?php

declare(strict_types=1);

namespace App\Domains\Product\Entity;

use App\Domains\Product\Interface\ProductInterface;

class Product implements ProductInterface
{
    public function __construct(
        protected string $id,
        protected string $name,
        protected bool $inStock,
        protected string $description,
        protected int $categoryId,
        protected int $brandId

    ) {}

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function isInStock(): bool
    {
        return $this->inStock;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getCategoryId(): int
    {
        return $this->categoryId;
    }

    public function getBrandId(): int
    {
        return $this->brandId;
    }
}
