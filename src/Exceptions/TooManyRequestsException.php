<?php namespace Nylas\Exceptions;

class TooManyRequestsException extends Exception
{
    protected $code = 429;

    protected $message = 'Slow down! (If you legitimately require this many requests, please contact support.)';
}
