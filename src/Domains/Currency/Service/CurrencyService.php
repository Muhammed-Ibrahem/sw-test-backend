<?php

declare(strict_types=1);

namespace App\Domains\Currency\Service;

use App\Domains\Currency\Repository\CurrencyRepository;
use App\Domains\Currency\Interface\CurrencyInterface;
use App\Domains\Currency\Enum\CurrencyEnum;

class CurrencyService
{
    public function __construct(private CurrencyRepository $repo) {}

    public function findCurrencyByIds(array $ids)
    {
        $rows = $this->repo->findByIds($ids);

        $currencies = $this->createCurrencyGroupedById($rows);

        return $currencies;
    }

    private function createCurrencyFromDBRow(array $row): CurrencyInterface
    {
        $id = $row['id'];
        $label = $row['label'];

        return CurrencyEnum::from($label)->getFactory()->createCurrency($id);
    }

    private function createCurrencyGroupedById(array $rows): array
    {
        $groupedCurrencies = [];

        foreach ($rows as $row) {
            $groupedCurrencies[$row['id']] = $this->createCurrencyFromDBRow($row);
        }

        return $groupedCurrencies;
    }
}
