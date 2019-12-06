<?php

namespace App\Request\Order;

use App\Currency\Currency;
use App\Entity\Order;

class PayOrderRequest
{
    protected $order;

    protected $amount;

    public function __construct(Order $order, Currency $currency)
    {
        $this->order = $order;
        $this->amount = $currency;
    }

    public function getOrder(): Order
    {
        return $this->order;
    }

    public function getAmount(): Currency
    {
        return $this->amount;
    }
}
