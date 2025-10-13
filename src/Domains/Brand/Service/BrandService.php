<?php

declare(strict_types=1);

namespace App\Domains\Brand\Service;

use App\Domains\Brand\Entity\Brand;
use App\Domains\Brand\Interface\BrandInterface;
use App\Domains\Brand\Repository\BrandRepository;

class BrandService
{
    public function __construct(private BrandRepository $repo) {}

    public function getBrandsByIds(array $ids)
    {
        $rows = $this->repo->findByIds($ids);

        $brands =  $this->createBrandsGroupedByIdFromRows($rows);

        return $brands;
    }

    private function createBrandFromRow(array $row): BrandInterface
    {
        $brandId = $row['id'];
        $brandName = $row['name'];

        return new Brand($brandId, $brandName);
    }

    private function createBrandsGroupedByIdFromRows(array $rows): array
    {
        $groupedBrands = [];

        foreach ($rows as $row) {
            $groupedBrands[$row['id']] = $this->createBrandFromRow($row);
        }

        return $groupedBrands;
    }
}
