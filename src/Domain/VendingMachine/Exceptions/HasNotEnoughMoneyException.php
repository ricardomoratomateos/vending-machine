<?php

namespace VendingMachine\Domain\VendingMachine\Exceptions;

use VendingMachine\Domain\LogicException;

class HasNotEnoughMoneyException extends LogicException
{
    const CODE = 3;
    const MESSAGE = 'The product is more expensive than the coins inserted.';
}
