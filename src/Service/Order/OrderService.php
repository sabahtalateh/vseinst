<?php

namespace App\Service\Order;

use App\Currency\Currency;
use App\DTO\PayOrderInfo;
use App\Entity\Order;
use App\Entity\Product;
use App\Enum\OrderPaymentStatus;
use App\Enum\OrderProcessStatus;
use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;

class OrderService
{
    private $orderRepository;
    /**
     * @var ConfirmationClient
     */
    private $confirmationClient;

    public function __construct(
        OrderRepository $orderRepository,
        ConfirmationClient $confirmationClient
    ) {
        $this->orderRepository = $orderRepository;
        $this->confirmationClient = $confirmationClient;
    }

    /**
     * @param Product[] $products
     */
    public function create(array $products): Order
    {
        $order = new Order();
        $order->setProducts(new ArrayCollection($products));

        $total = new Currency();

        foreach ($products as $product) {
            $total = $total->add($product->getPrice());
        }
        $order->setTotal($total);

        return $this->orderRepository->save($order);
    }

    public function pay(Order $order, Currency $amount): PayOrderInfo
    {
        if ($order->isPayed()) {
            return new PayOrderInfo($order, OrderPaymentStatus::ALREADY_PAYED());
        }

        if ($order->getTotal()->equals($amount)) {
            $confirmed = $this->confirmationClient->confirm();
            if ($confirmed) {
                $order->setProcessStatus(OrderProcessStatus::PAYED());
                $this->orderRepository->save($order);
                $status = OrderPaymentStatus::SUCCESS();
            } else {
                $status = OrderPaymentStatus::CONFIRMATION_FAILED();
            }
        } else {
            $status = OrderPaymentStatus::INVALID_AMOUNT();
        }

        return new PayOrderInfo($order, $status);
    }
}
