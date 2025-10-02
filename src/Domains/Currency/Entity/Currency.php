<?php

declare(strict_types=1);

namespace App\Domains\Currency\Entity;

use App\Domains\Currency\Interface\CurrencyInterface;
use App\Domains\Currency\Enum\CurrencySymbol;
use App\Domains\Currency\Enum\CurrencyLabel;

abstract class Currency implements CurrencyInterface
{
    public function __construct(
        protected int $id,
        protected CurrencyLabel $label,
        protected CurrencySymbol $symbol
    ) {}

    public function getId(): int
    {
        return $this->id;
    }

    public function getLabel(): string
    {
        return $this->label->value;
    }

    public function getSymbol(): string
    {
        return $this->symbol->value;
    }
}
