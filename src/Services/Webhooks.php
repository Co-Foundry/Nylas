<?php

namespace Nylas\Services;

use Nylas\Exceptions\Exception;
use Nylas\Helpers\Collection;
use Nylas\Resources\Webhook;
use Nylas\Services\Service;

class Webhooks extends Service
{
    const URI_ALL = '/webhooks';
    const URI_ONE = '/webhooks/{id}';

    /**
     * Get all webhooks
     *
     * @param array $filters
     * @return Collection
     */
    public function find($filters = [])
    {
        return (new Collection($this->client, Webhook::class, self::URI_ALL))->where($filters);
    }

    /**
     * Get one webhook
     *
     * @param $id
     * @return mixed
     * @throws Exception
     */
    public function read($id)
    {
        return new Webhook($this->client->call(sprintf(self::URI_ONE, $id)));
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
    public function create(string $callback_url, array $triggers, string $state)
    {
        return new Webhook($this->client->call(self::URI_ALL, 'POST', [
            'callback_url' => $callback_url,
            'triggers' => $triggers,
            'state' => $state
        ]));
    }

    /**
     * Update a webhook
     *
     * @param $id
     * @param $state
     * @return mixed
     * @throws Exception
     */
    public function update($id, $state)
    {
        return new Webhook($this->client->call(sprintf(self::URI_ONE, $id), 'POST', [
            'state' => $state
        ]));
    }

    /**
     * Delete a webhook
     *
     * @param string|integer $id
     * @return mixed
     * @throws Exception
     */
    public function delete($id)
    {
        $this->client->call(sprintf(self::URI_ONE, $id), 'DELETE');
        return true;
    }
}
