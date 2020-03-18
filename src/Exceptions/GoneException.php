<?php namespace Nylas\Exceptions;

class GoneException extends Exception
{
    protected $code = 410;

    protected $message = 'The requested resource has been removed from our servers.';
}
