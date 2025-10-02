<?php

declare(strict_types=1);

namespace App\Domains\Currency\Entity;


use App\Domains\Currency\Enum\CurrencySymbol;
use App\Domains\Currency\Enum\CurrencyLabel;
use App\Domains\Currency\Entity\Currency;

class USD extends Currency
{

    public function __construct(int $id)
    {
        parent::__construct($id, CurrencyLabel::USD, CurrencySymbol::DOLLAR);
    }
}
