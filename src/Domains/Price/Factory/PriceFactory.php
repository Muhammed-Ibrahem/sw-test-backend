<?php

declare(strict_types=1);

namespace App\Domains\Price\Factory;

use App\Domains\Price\Entity\Price;
use App\Domains\Price\Interface\PriceInterface;

class PriceFactory
{
    public static function createPrice(
        int $id,
        float $amount,
        string $productId,
        int $currencyId
    ): PriceInterface {
        return new Price(
            $id,
            $amount,
            $productId,
            $currencyId
        );
    }
}
