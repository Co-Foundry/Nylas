<?php

namespace Nylas\Services;

use Nylas\Nylas;

/**
 * Service
 *
 * Base Service class
 *
 * @author Greg Gunner <greg@co-foundry.co.za>
 * @package Nylas\Services
 */
abstract class Service
{

    /**
     * @var Nylas
     */
    protected $nylas;

    /**
     * BaseService constructor.
     * @param $nylas
     */
    public function __construct($nylas)
    {
        $this->nylas = $nylas;
    }

    /**
     * Get an instance of the request object
     *
     * @return \Nylas\Request
     */
    protected function request()
    {
        return $this->nylas->request();
    }

    /**
     * Pass through to the client
     *
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        if (method_exists($this->nylas, $name)) {
            return call_user_func([$this->nylas, $name], ...$arguments);
        }
    }

}
