<?php

namespace App\Service;

use App\Currency\Currency;
use App\Entity\Order;
use App\Entity\Product;
use App\Enum\OrderProcessStatus;
use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;

class OrderService
{
    private $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
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

    public function pay(Order $order, Currency $amount): Order
    {
        if ($order->isPayed()) {
            return $order;
        }

        if ($order->getTotal()->equals($amount)) {
            $order->setProcessStatus(OrderProcessStatus::PAYED());
            $this->orderRepository->save($order);
        }

        return $order;
    }
}
