<?php

namespace VendingMachine\Domain\VendingMachine\Exceptions;

use VendingMachine\Domain\LogicException;

class MachineHasNotEnoughChangeException extends LogicException
{
    const CODE = 2;
    const MESSAGE = 'The vending machine has not enough change.';
}
