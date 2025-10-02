<?php

declare(strict_types=1);

namespace App\Domains\Price\Service;

use Exception;

use App\Domains\Price\Repository\PriceRepository;
use App\Domains\Price\Interface\PriceInterface;
use App\Domains\Price\Factory\PriceFactory;

class PriceService
{
    public function __construct(
        private PriceRepository $repo
    ) {}

    public function getPricesByProductIds(array $productIds): array
    {
        try {
            $rows = $this->repo->findPriceByProductIds($productIds);

            $gallery = $this->createPriceGroupedByProductId($rows);

            return $gallery;
        } catch (Exception $e) {
            throw new Exception("Failed to retrieve prices: {$e->getMessage()}");
        }
    }
    private function createPriceFromDBRow(array $row): PriceInterface
    {
        $id = $row['id'];
        $amount =  (float) $row['amount'];
        $productId = $row['product_id'];
        $currencyId = $row['currency_id'];

        return PriceFactory::createPrice($id, $amount, $productId, $currencyId);
    }

    private function createPriceGroupedByProductId(array $rows): array
    {
        $groupedPrices = [];

        foreach ($rows as $row) {
            $groupedPrices[$row['product_id']][]  = $this->createPriceFromDBRow($row);
        }

        return $groupedPrices;
    }
}
