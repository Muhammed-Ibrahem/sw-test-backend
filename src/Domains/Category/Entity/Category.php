<?php

declare(strict_types=1);

namespace App\Domains\Category\Entity;

use App\Domains\Category\Interface\CategoryInterface;

class Category implements CategoryInterface
{
    protected int $id;
    protected string $name;

    public function __construct(int $id, string $name)
    {
        $this->name = $name;
        $this->id = $id;
    }

    public function  getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
