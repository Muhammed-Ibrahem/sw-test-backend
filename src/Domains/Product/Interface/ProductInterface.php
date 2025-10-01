<?php

declare(strict_types=1);

namespace App\Domains\Product\Interface;

interface ProductInterface
{
    /**
     * Get the product ID
     * @return string
     */
    public function getId(): string;

    /**
     * get the NAME of the product
     * @return string
     */
    public function getName(): string;

    /**
     * Get the availability of the product
     * @return bool
     */
    public function isInStock(): bool;

    /**
     * Get the product Description
     * @return string
     */
    public function getDescription(): string;

    /**
     * Get the CategoryId that the product is related to
     * @return int
     */
    public function getCategoryId(): int;

    /**
     * Get the BrandId that the product is related to
     * @return int
     */
    public function getBrandId(): int;
}
