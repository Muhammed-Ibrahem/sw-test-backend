<?php

declare(strict_types=1);

namespace App\Domains\Category\Interface;

interface CategoryInterface
{
    /**
     * Get the ID of the category
     * @return int
     */
    public function getId(): int;

    /**
     * Get the NAME of the category
     * @return string
     */
    public function getName(): string;
}
