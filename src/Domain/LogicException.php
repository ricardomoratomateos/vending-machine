<?php

namespace VendingMachine\Domain;

use JsonSerializable;
use LogicException as GlobalLogicException;

class LogicException extends GlobalLogicException implements JsonSerializable
{
    const CODE = 0;
    const MESSAGE = '';

    public function jsonSerialize()
    {
        return [
            'code' => $this::CODE,
            'message' => $this::MESSAGE,
        ];
    }
}
