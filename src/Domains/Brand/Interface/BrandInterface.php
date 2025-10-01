<?php

declare(strict_types=1);

namespace App\Domains\Brand\Interface;

interface BrandInterface
{
    /**
     * Get the ID of a brand
     * @return int
     */
    public function getId(): int;

    /**
     * get the NAME of a brand
     * @return string
     */
    public function getName(): string;
}
