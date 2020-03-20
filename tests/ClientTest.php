<?php
namespace Tests;

final class ClientTest extends BaseTestCase
{
    public function testClientInstance(): void
    {
        $this->assertInstanceOf(
            \Nylas\Nylas::class,
            $this->client
        );
    }

}
