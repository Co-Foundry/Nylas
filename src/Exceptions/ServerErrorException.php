<?php namespace Nylas\Exceptions;

class ServerErrorException extends Exception
{
    protected $code = 500;

    protected $message = 'An error occurred in the Nylas server. If this persists, please see our status page or contact support.';
}
