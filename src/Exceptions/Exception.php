<?php namespace Nylas\Exceptions;

/**
 * Class Exception
 *
 * Base Nylas Exception class
 *
 * @package Nylas\Exceptions
 */
class Exception extends \Exception
{

    protected $type;

    /**
     * @param mixed $type
     * @return self
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    static function getExceptionClass($code)
    {
        switch ($code){
            case 202:
                return NotReadyException::class;
            case 400:
                return BadRequestException::class;
            case 401:
                return UnauthorizedException::class;
            case 402:
                return RequestFailedException::class;
            case 403:
                return ForbiddenException::class;
            case 404:
                return NotFoundException::class;
            case 405:
                return MethodNotAllowedException::class;
            case 410:
                return GoneException::class;
            case 418:
                return TeapotException::class;
            case 422:
                return SendingErrorException::class;
            case 429:
                return TooManyRequestsException::class;
            case 500:
            case 502:
            case 503:
            case 504:
                return ServerErrorException::class;
            default:
                return Exception::class;
        }
    }
}
