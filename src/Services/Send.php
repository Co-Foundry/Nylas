<?php

namespace Nylas\Services;

use Nylas\Exceptions\Exception;
use Nylas\Resources\Draft;
use Nylas\Resources\Message;

class Send extends Service
{
    const PATH_SEND = '/send';

    /**
     * @param string $id
     * @param $version
     * @param array|null $tracking
     * @return bool
     * @throws Exception
     */
    public function sendDraft(string $id, $version, ?array $tracking = null): bool
    {
        return $this->request()->withBearerTokenAuth()->setPath(static::PATH_SEND)->post([
            'draft_id' => $id,
            'version' => $version,
            'tracking' => $tracking
        ])->isSuccess();
    }

    /**
     * @param array $to
     * @param array $from
     * @param string $subject
     * @param string $body
     * @param string|null $reply_to_message_id
     * @param array|null $cc
     * @param array|null $bcc
     * @param array|null $reply_to
     * @param array|null $file_ids
     * @param bool $send
     * @param array|null $tracking
     * @return Message
     * @throws Exception
     */
    public function sendDirect(array $to, array $from, string $subject, string $body, ?string $reply_to_message_id = null, array $cc = [], array $bcc = [], array $reply_to = [], array $file_ids = [], $send = false, ?array $tracking = null): Message
    {
        $params = [
            'subject' => $subject,
            'to' => $to,
            'cc' => $cc,
            'bcc' => $bcc,
            'from' => $from,
            'reply_to' => $reply_to,
            'reply_to_message_id' => $reply_to_message_id,
            'body' => $body,
            'file_ids' => $file_ids,
            'tracking' => $tracking
        ];
        return new Message($this->request()->withBearerTokenAuth()->setPath(static::PATH_SEND)->post($params)->toArray());
    }

    /**
     * Send a raw MIME message
     *
     * @param string $data
     * @return Message
     * @throws Exception
     */
    public function sendRaw(string $data): Message
    {
        return new Message($this->request()
            ->withBearerTokenAuth()
            ->setHeader('Content-Type', 'message/rfc822')
            ->setPath(static::PATH_SEND)
            ->setBody($data)
            ->post()
            ->toArray()
        );
    }


}
