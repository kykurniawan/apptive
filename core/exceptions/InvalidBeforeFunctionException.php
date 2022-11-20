<?php

namespace Apptive\Core\Exceptions;

use \Exception;

class InvalidBeforeFunctionException extends Exception
{
    public function __construct($functionName)
    {
        parent::__construct('Invalid Before Function: ' . $functionName);
    }
}
