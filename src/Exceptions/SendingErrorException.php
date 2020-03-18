<?php namespace Nylas\Exceptions;

class SendingErrorException extends Exception
{
    protected $code = 422;

    protected $message = 'This is returned during sending. See sending errors';
}
