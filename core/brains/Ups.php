<?php

namespace Apptive\Core\Brains;

use Apptive\Core\Exceptions\InvalidBeforeFunctionException;
use Apptive\Core\Exceptions\PageNotFoundException;
use Apptive\Core\Exceptions\UnauthorizedException;

class Ups
{
    public static function pageNotFound($message = 'Page Not Found')
    {
        throw new PageNotFoundException($message);
    }

    public static function unauthorized($message = 'Unauthorized')
    {
        throw new UnauthorizedException($message);
    }

    public static function invalidBeforeFunction($functionName)
    {
        throw new InvalidBeforeFunctionException($functionName);
    }

    public static function handler($error)
    {
        if ($error instanceof PageNotFoundException) {
            Response::make($error->getCode())->sendError('error', ['error' => $error]);
            exit();
        }

        if ($error instanceof UnauthorizedException) {
            Response::make($error->getCode())->sendError('error', ['error' => $error]);
            exit();
        }

        throw $error;
    }
}
