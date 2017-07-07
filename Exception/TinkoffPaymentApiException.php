<?php

namespace Lopatinas\TinkoffPaymentBundle\Exception;

use Throwable;

class TinkoffPaymentApiException extends \LogicException
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
