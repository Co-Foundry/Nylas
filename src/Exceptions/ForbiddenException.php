<?php namespace Nylas\Exceptions;

class ForbiddenException extends Exception
{
    protected $code = 403;

    protected $message = 'Includes authentication errors, blocked developer applications, and cancelled accounts.';
}
