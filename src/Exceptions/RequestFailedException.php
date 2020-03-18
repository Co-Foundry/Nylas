<?php namespace Nylas\Exceptions;

class RequestFailedException extends Exception
{
    protected $code = 402;

    protected $message = 'Parameters were valid but the request failed. Or, a credit card must be added to your Organization.';
}
