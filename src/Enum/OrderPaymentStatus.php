<?php

namespace App\Enum;

use MyCLabs\Enum\Enum;

/**
 * @method static OrderPaymentStatus SUCCESS()
 * @method static OrderPaymentStatus ALREADY_PAYED()
 * @method static OrderPaymentStatus CONFIRMATION_FAILED()
 * @method static OrderPaymentStatus INVALID_AMOUNT()
 */
class OrderPaymentStatus extends Enum
{
    const SUCCESS = 'success';
    const ALREADY_PAYED = 'already_payed';
    const CONFIRMATION_FAILED = 'confirmation_failed';
    const INVALID_AMOUNT = 'invalid_amount';
}
