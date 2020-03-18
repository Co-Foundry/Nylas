<?php
namespace Tests;

final class ClientTest extends BaseTestCase
{
    public function testClientInstance(): void
    {
        $this->assertInstanceOf(
            \Nylas\Client::class,
            $this->client
        );
    }

}
