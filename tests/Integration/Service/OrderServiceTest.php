<?php

namespace App\Tests\Integration\Service;

use App\Currency\Currency;
use App\Entity\Product;
use App\Enum\OrderProcessStatus;
use App\Repository\ProductRepository;
use App\Service\OrderService;
use PHPUnit\Framework\TestCase;

class OrderServiceTest extends TestCase
{
    private $container;

    public function __construct()
    {
        $this->container = require(__DIR__).'/../../../src/config/bootstrap.php';
        parent::__construct();
    }

    public function testOrderTotalCount()
    {
        /** @var OrderService $orderService */
        $orderService = $this->container->get(OrderService::class);
        /** @var ProductRepository $productRepo */
        $productRepo = $this->container->get(ProductRepository::class);

        $p1 = new Product();
        $p1->setName('p1');
        $p1->setPrice(new Currency(1, 11));

        $p2 = new Product();
        $p2->setName('p2');
        $p2->setPrice(new Currency(1, 45));

        $p3 = new Product();
        $p3->setName('p3');
        $p3->setPrice(new Currency(2, 61));

        $productRepo->save($p1);
        $productRepo->save($p2);
        $productRepo->save($p3);

        $total = 111 + 145 + 261;
        $totalInteger = (int) $total / 100;
        $totalDecimal = $total % 100;
        $expectedTotal = new Currency($totalInteger, $totalDecimal);

        $order = $orderService->create([$p1, $p2, $p3]);

        $this->assertTrue($order->getTotal()->equals($expectedTotal));
    }

    public function testStatusNotSetToPayedWhenTotalNotEquals()
    {
        /** @var OrderService $orderService */
        $orderService = $this->container->get(OrderService::class);
        /** @var ProductRepository $productRepo */
        $productRepo = $this->container->get(ProductRepository::class);

        $p1 = new Product();
        $p1->setName('p1');
        $p1->setPrice(new Currency(1, 0));

        $p2 = new Product();
        $p2->setName('p2');
        $p2->setPrice(new Currency(1, 0));

        $productRepo->save($p1);
        $productRepo->save($p2);

        $order = $orderService->create([$p1, $p2]);

        $order = $orderService->pay($order, new Currency(2, 50));

        $this->assertNotEquals($order->getProcessStatus(), OrderProcessStatus::PAYED());
    }

    public function testStatusSetToPayedWhenTotalEquals()
    {
        /** @var OrderService $orderService */
        $orderService = $this->container->get(OrderService::class);
        /** @var ProductRepository $productRepo */
        $productRepo = $this->container->get(ProductRepository::class);

        $p1 = new Product();
        $p1->setName('p1');
        $p1->setPrice(new Currency(1, 20));

        $p2 = new Product();
        $p2->setName('p2');
        $p2->setPrice(new Currency(2, 52));

        $productRepo->save($p1);
        $productRepo->save($p2);

        $order = $orderService->create([$p1, $p2]);

        $order = $orderService->pay($order, new Currency(3, 72));

        $this->assertEquals($order->getProcessStatus(), OrderProcessStatus::PAYED());
    }
}
