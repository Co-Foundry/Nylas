<?php

namespace Nylas\Services;

use Nylas\Client;

abstract class Service
{

    /**
     * @var Client
     */
    protected $client;

    /**
     * BaseService constructor.
     * @param $client
     */
    public function __construct($client)
    {
        $this->client = $client;
    }

}
