<?php

namespace VendingMachine\Application\VendingMachine\Exceptions;

use VendingMachine\Domain\LogicException;

class InvalidItemException extends LogicException
{
    const CODE = 3;
    const MESSAGE = 'The item does not exist.';
}
