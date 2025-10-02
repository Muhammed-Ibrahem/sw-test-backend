<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

use App\Domains\Currency\Interface\CurrencyInterface;

class CurrencyType extends ObjectType
{
    public function __construct()
    {
        parent::__construct([
            "name" => "Currency",
            "fields" => fn(): array => [
                "id" => [
                    "type" => Type::nonNull(Type::id()),
                    "resolve" => fn(CurrencyInterface $currency): int  => $currency->getId()
                ],
                "label" => [
                    "type" => Type::nonNull(Type::string()),
                    "resolve" => fn(CurrencyInterface $currency): string => $currency->getLabel(),
                ],
                "symbol" => [
                    "type" => Type::nonNull(Type::string()),
                    "resolve" => fn(CurrencyInterface $currency): string => $currency->getSymbol()
                ]
            ],
        ]);
    }
}
