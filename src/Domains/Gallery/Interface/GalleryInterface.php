<?php

declare(strict_types=1);

namespace App\Domains\Gallery\Interface;

interface GalleryInterface
{
    public function getId(): int;

    public function getUrl(): string;

    public function getProductId(): string;
}
