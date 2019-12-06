<?php

namespace App\Request\Order;

use App\Currency\CreateCurrencyException;
use App\Currency\Currency;
use App\Entity\Order;
use App\Repository\OrderRepository;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class PayOrderRequestTransformer
{
    private $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function transform(string $orderId, array $body): PayOrderRequest
    {
        /** @var Order $order */
        $order = $this->orderRepository->find((int) $orderId);
        if (null === $order) {
            throw new BadRequestHttpException('No order found.');
        }

        $amount = $body['amount'] ?? null;
        if (null === $amount) {
            throw new BadRequestHttpException('No amount provided.');
        }

        try {
            $amount = Currency::fromString($amount);
        } catch (CreateCurrencyException $exception) {
            throw new BadRequestHttpException($exception->getMessage());
        }

        return new PayOrderRequest($order, $amount);
    }
}
