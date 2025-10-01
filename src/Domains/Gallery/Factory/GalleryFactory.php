<?php

declare(strict_types=1);

namespace App\Domains\Gallery\Factory;

use App\Domains\Gallery\Entity\Gallery;
use App\Domains\Gallery\Interface\GalleryInterface;

class GalleryFactory
{
    public static function createGallery(
        int $id,
        string $url,
        string $productId
    ): GalleryInterface {
        return new Gallery($id, $url, $productId);
    }
}
