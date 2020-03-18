<?php namespace Nylas\Exceptions;

class MethodNotAllowedException extends Exception
{
    protected $code = 405;

    protected $message = 'You tried to access a resource with an invalid method.';
}
