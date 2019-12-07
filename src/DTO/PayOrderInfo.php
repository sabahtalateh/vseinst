<?php

namespace App\DTO;

use App\Entity\Order;
use App\Enum\OrderPaymentStatus;
use JMS\Serializer\Annotation as JMS;

class PayOrderInfo
{
    /**
     * @JMS\Expose
     */
    private $order;

    /**
     * @JMS\Expose
     */
    private $orderPaymentStatus;

    public function __construct(Order $order, OrderPaymentStatus $orderPaymentStatus)
    {
        $this->order = $order;
        $this->orderPaymentStatus = $orderPaymentStatus->getValue();
    }

    public function getOrder(): Order
    {
        return $this->order;
    }

    public function getOrderPaymentStatus(): string
    {
        return $this->orderPaymentStatus;
    }
}
