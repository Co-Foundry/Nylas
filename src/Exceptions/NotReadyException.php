<?php namespace Nylas\Exceptions;

class NotReadyException extends Exception
{
    protected $code = 202;

    protected $message = "The request was valid but the resource wasn't ready. Retry the request with exponential backoff";
}
