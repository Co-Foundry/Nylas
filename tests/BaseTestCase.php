<?php
namespace Tests;

use PHPUnit\Framework\TestCase;

class BaseTestCase extends TestCase
{
    protected $client;

    protected function setUp()
    {
        parent::setUp();
        $this->client = new \Nylas\Client($_ENV['NYLAS_CLIENT_ID'], $_ENV['NYLAS_CLIENT_SECRET'], $_ENV['NYLAS_ACCESS_TOKEN']);
    }

}
