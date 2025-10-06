<?php

declare(strict_types=1);

namespace App\GraphQL\InputTypes;

use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\Type;

class OrderItemAttributeInputType extends InputObjectType
{
    public function __construct()
    {
        parent::__construct([
            "name" => "OrderItemAttributeInputType",
            "fields" => [
                "attributeSetId" => Type::nonNull(Type::id()),
                "attributeId" => Type::nonNull(Type::id())
            ]
        ]);
    }
}
