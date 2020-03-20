<?php

namespace Nylas\Services;

use Nylas\Exceptions\Exception;
use Nylas\Helpers\Collection;
use Nylas\Request;
use Nylas\Resources\Webhook;

/**
 * Class Webhooks
 *
 * @author Greg Gunner <greg@co-foundry.co.za>
 * @package Nylas\Services
 */
class Webhooks extends Service
{
    const PATH_WEBHOOKS = '/webhooks';
    const PATH_WEBHOOK = '/webhooks/{id}';

    /**
     * Get all webhooks
     *
     * @param array $filters
     * @return Collection
     */
    public function getWebhooks($filters = [])
    {
        return (new Collection(
            $this->request()->setPath(sprintf(self::PATH_WEBHOOKS)),
            Webhook::class)
        )->where($filters);
    }

    /**
     * Get one webhook
     *
     * @param $id
     * @return mixed
     * @throws Exception
     */
    public function getWebhook($id)
    {
        return new Webhook(
            $this->request()->setPath(sprintf(self::PATH_WEBHOOK, $id))->get()->toJson()
        );
    }

    /**
     * Create a new webhook
     *
     * @param string $callback_url
     * @param array $triggers
     * @param string $state
     * @return mixed
     * @throws Exception
     */
    public function createWebhook(string $callback_url, array $triggers, string $state)
    {
        return new Webhook(
            $this->request()
                ->setPath(self::PATH_WEBHOOKS)
                ->post([
                    'callback_url' => $callback_url,
                    'triggers' => $triggers,
                    'state' => $state
                ])
                ->toJson()
        );
    }

    /**
     * Update a webhook
     *
     * @param $id
     * @param $state
     * @return mixed
     * @throws Exception
     */
    public function updateWebhook($id, $state)
    {
        return new Webhook(
            $this->request()
                ->setPath(sprintf(self::PATH_WEBHOOK, $id))
                ->put([
                    'state' => $state
                ])
                ->toJson()
        );
    }

    /**
     * Delete a webhook
     *
     * @param string|integer $id
     * @return boolean
     * @throws Exception
     */
    public function deleteWebhook($id)
    {
        return $this->request()
            ->setPath(sprintf(self::PATH_WEBHOOK, $id))
            ->delete()
            ->isSuccess()
        ;
    }

    /**
     * Modify the request to include the client id
     *
     * @return Request
     */
    protected function request()
    {
        return parent::request()->withClientId();
    }
}
