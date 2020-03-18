<?php
namespace Tests;

use Nylas\Resources\Webhook;
use Nylas\Services\Webhooks;

final class WebhooksTest extends BaseTestCase
{
    public function testGetWebhooks(): void
    {

        /** @var Webhooks $Webhooks */
        /** @var Webhook $Webhook */
        $Webhooks = $this->client->WebHooks();

        $Webhook = $Webhooks->create('https://localhost', ['account.connected'], 'inactive');

        print_r($Webhook->toArray());

//        $Collection = $Webhooks->find();
//
//
//        foreach ($Collection as $Webhook) {
//            print_r($Webhook->toArray());
//        }
//        die();
    }

}
