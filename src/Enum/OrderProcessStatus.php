<?php

namespace App\Enum;

use MyCLabs\Enum\Enum;

/**
 * @method static OrderProcessStatus NEW()
 * @method static OrderProcessStatus PAYED()
 */
class OrderProcessStatus extends Enum
{
    const NEW = 'new';
    const PAYED = 'payed';
}
