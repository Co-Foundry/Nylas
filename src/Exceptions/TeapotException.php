<?php namespace Nylas\Exceptions;

class TeapotException extends Exception
{
    protected $code = 418;

    protected $message = "I'm a teapot";
}
