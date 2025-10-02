<?php

declare(strict_types=1);

namespace App\GraphQL\DataLoader;

use App\Domains\Gallery\Service\GalleryService;

class GalleryLoader extends Loader
{
    public function __construct(private GalleryService $galleryService) {}

    public function  loadBuffered(): void
    {
        $this->loadBatch([$this->galleryService, 'getGalleryByProductIds']);
    }
}
