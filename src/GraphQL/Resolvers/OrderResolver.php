<?php

declare(strict_types=1);

namespace App\GraphQL\Resolvers;

use App\Domains\Order\Service\OrderPlacementService;

class OrderResolver
{
    public function __construct(
        private OrderPlacementService $orderPlacementService
    ) {}
    public function placeOrder($root, array $args)
    {
        return $this->orderPlacementService->placeOrder($args['orderItems']);
    }
}
