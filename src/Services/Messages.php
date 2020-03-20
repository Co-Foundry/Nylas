<?php

namespace Nylas\Services;

use Nylas\Exceptions\Exception;
use Nylas\Helpers\Collection;
use Nylas\Resources\Message;

/**
 * Class Messages
 *
 * @package Nylas\Services
 * @todo add message update
 * @todo add get raw message contents
 */
class Messages extends Service
{
    const PATH_MESSAGES = '/messages';
    const PATH_MESSAGE = '/messages/%s';

    /**
     * Get all messages
     *
     * @param array $filters
     * @return Collection|Messages[]
     */
    public function getMessages($filters = [])
    {
        return (new Collection(
            $this->request()->withBearerTokenAuth()->setPath(self::PATH_MESSAGES), Message::class)
        )->where($filters);
    }

    /**
     * Get a message
     *
     * @param $id
     * @return Message
     * @throws Exception
     */
    public function getMessage($id)
    {
        return new Message($this->request()->withBearerTokenAuth()->setPath(sprintf(self::PATH_MESSAGE, $id))->get()->toJson());
    }

}
