<?php

declare(strict_types=1);

namespace App\Domains\Gallery\Entity;

use App\Domains\Gallery\Interface\GalleryInterface;

class Gallery implements GalleryInterface
{
    public function __construct(
        protected int $id,
        protected string $url,
        protected string $productId
    ) {}

    public function getId(): int
    {
        return $this->id;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getProductId(): string
    {
        return $this->productId;
    }
}
