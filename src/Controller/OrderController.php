<?php

namespace App\Controller;

use App\Request\Order\CreateOrderRequestTransformer;
use App\Request\Order\PayOrderRequestTransformer;
use App\Service\OrderService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class OrderController extends BaseController
{
    public function create(Request $request): JsonResponse
    {
        /** @var CreateOrderRequestTransformer $orderRequestTransformer */
        $orderRequestTransformer = $this->get(CreateOrderRequestTransformer::class);
        $body = $this->jsonRequestToArray($request);
        $products = $orderRequestTransformer->transform($body);

        /** @var OrderService $orderService */
        $orderService = $this->get(OrderService::class);
        $order = $orderService->create($products);

        return $this->jsonResponse($order);
    }

    public function pay(Request $request, string $orderId): JsonResponse
    {
        /** @var PayOrderRequestTransformer $payOrderRequestTransformer */
        $payOrderRequestTransformer = $this->get(PayOrderRequestTransformer::class);
        $body = $this->jsonRequestToArray($request);

        $payOrderRequest = $payOrderRequestTransformer->transform($orderId, $body);

        /** @var OrderService $orderService */
        $orderService = $this->get(OrderService::class);
        $order = $orderService->pay(
            $payOrderRequest->getOrder(),
            $payOrderRequest->getAmount()
        );

        return $this->jsonResponse($order);
    }
}
