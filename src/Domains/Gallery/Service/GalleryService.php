<?php

declare(strict_types=1);

namespace App\Domains\Gallery\Service;

use App\Domains\Gallery\Factory\GalleryFactory;
use App\Domains\Gallery\Repository\GalleryRepository;
use App\Domains\Gallery\Interface\GalleryInterface;

class GalleryService
{
    public function __construct(private GalleryRepository $repo) {}

    public function getGalleryByProductIds(array $productIds): array
    {
        $rows = $this->repo->findGalleryByProductIds($productIds);

        $gallery = $this->createGalleryGroupedByProductId($rows);

        return $gallery;
    }

    private function createGalleryFromDBRow(array $row): GalleryInterface
    {
        $id = $row['id'];
        $url = $row['url'];
        $productId = $row['product_id'];

        return GalleryFactory::createGallery($id, $url, $productId);
    }

    private function createGalleryGroupedByProductId(array $rows): array
    {
        $groupedGallery = [];

        foreach ($rows as $row) {
            $groupedGallery[$row['product_id']][]  = $this->createGalleryFromDBRow($row);
        }

        return $groupedGallery;
    }
}
