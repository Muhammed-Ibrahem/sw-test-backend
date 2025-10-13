<?php

declare(strict_types=1);

namespace App\Domains\Order\Service;

use Exception;
use PDO;

use App\Core\Logger\LoggerLevelsEnum;
use App\Core\Logger\Logger;

use App\Exceptions\DatabaseException;
use App\Exceptions\AppException;

use App\Domains\OrderItem\DTO\OrderItemDTO;
use App\Domains\Order\DTO\OrderDTO;

use App\Domains\OrderItemAttribute\Repository\OrderItemAttributeRepository;
use App\Domains\OrderItem\Repository\OrderItemRepository;
use App\Domains\Order\Repository\OrderRepository;

class OrderPlacementService
{
    public function __construct(
        private PDO $connection,
        private OrderRepository $orderRepository,
        private OrderItemRepository $orderItemRepository,
        private OrderItemAttributeRepository $orderItemAttributeRepository
    ) {}


    public function placeOrder(OrderDTO $order): int
    {
        $items = $order->getOrderItems();
        $orderCurrencyId = $items[0]->getCurrencyId();
        $totalAmount = $this->calculateTotalPrice($items);

        try {
            $this->connection->beginTransaction();

            $orderId = $this->orderRepository->createOrder($totalAmount, $orderCurrencyId);

            foreach ($items as $item) {
                $orderItemId = $this->orderItemRepository->createOrderItem(
                    $orderId,
                    $item->getProductId(),
                    $item->getQuantity(),
                    $item->getUnitPrice(),
                    $item->getCurrencyId()
                );

                $itemAttributes = $item->getAttributes();

                foreach ($itemAttributes as $attr) {
                    $this->orderItemAttributeRepository->createOrderItemAttribute(
                        $orderItemId,
                        $attr->getAttributeId(),
                        $attr->getAttributeSetId()
                    );
                }
            }

            $this->connection->commit();

            Logger::log("A new order was placed with an ID of #{$orderId}", LoggerLevelsEnum::INFO);
            return $orderId;
        } catch (DatabaseException $e) {
            Logger::log("Order Transaction failed: {$e->getMessage()}", LoggerLevelsEnum::ERROR);

            $this->connection->rollBack();

            throw $e;
        } catch (Exception $e) {
            Logger::log("Order Transaction failed: {$e->getMessage()}", LoggerLevelsEnum::ERROR);

            $this->connection->rollBack();

            throw new AppException();
        }
    }

    /** @param OrderItemDTO[] $items */
    private function calculateTotalPrice(array $items): float
    {
        $total = 0.00;

        foreach ($items as $item) {
            $total += $item->getUnitPrice() * $item->getQuantity();
        }

        return $total;
    }
}
