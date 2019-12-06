<?php

namespace App\Repository;

use App\Entity\Order;

class OrderRepository extends AbstractRepository
{
    protected function entityClass(): string
    {
        return Order::class;
    }
}
