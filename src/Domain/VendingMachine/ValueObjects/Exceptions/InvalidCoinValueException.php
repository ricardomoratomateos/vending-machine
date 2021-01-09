<?php

namespace VendingMachine\Domain\VendingMachine\ValueObjects\Exceptions;

use VendingMachine\Domain\LogicException;

class InvalidCoinValueException extends LogicException
{
    const CODE = 1;
    const MESSAGE = 'The value of the coind should be 0.05, 0.10, 0.25 or 1.00.';
}
