<?php namespace Nylas\Exceptions;

class NotFoundException extends Exception
{
    protected $code = 404;

    protected $message = "The requested item doesn't exist.";
}
