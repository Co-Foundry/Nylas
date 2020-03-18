<?php namespace Nylas\Exceptions;

class BadRequestException extends Exception
{
    protected $code = 400;

    protected $message = 'Malformed or missing a required parameter.';
}
