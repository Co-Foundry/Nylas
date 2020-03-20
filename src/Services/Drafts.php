<?php

namespace Nylas\Services;

use Nylas\Exceptions\Exception;
use Nylas\Helpers\Collection;
use Nylas\Resources\Draft;

/**
 * Class Drafts
 *
 * @package Nylas\Services
 */
class Drafts extends Service
{
    const PATH_DRAFTS = '/drafts';
    const PATH_DRAFT = '/drafts/%s';
    const PATH_SEND = '/send';

    /**
     * Get all draft
     *
     * @param array $filters
     * @return Collection|Drafts[]
     */
    public function getDrafts($filters = [])
    {
        return (new Collection(
            $this->request()->withBearerTokenAuth()->setPath(self::PATH_DRAFTS), Draft::class)
        )->where($filters);
    }

    /**
     * Get a draft
     *
     * @param $id
     * @return mixed
     * @throws Exception
     */
    public function getDraft($id)
    {
        return new Draft($this->request()->withBearerTokenAuth()->setPath(sprintf(self::PATH_DRAFT, $id))->get()->toArray());
    }

    /**
     * @param array $to array of name+email pair
     * @param array $from array of name+email pair
     * @param string $subject
     * @param string $body
     * @param string|null $reply_to_message_id
     * @param array $cc array of name+email pair
     * @param array $bcc array of name+email pair
     * @param array $reply_to array of name+email pair
     * @param array $file_ids array of file ids (must have been uploaded first)
     * @return Draft
     * @throws Exception
     */
    public function createDraft(array $to, array $from, string $subject, string $body, ?string $reply_to_message_id = null, array $cc = [], array $bcc = [], array $reply_to = [], array $file_ids = [])
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
            'file_ids' => $file_ids
        ];
        return new Draft($this->request()->withBearerTokenAuth()->setPath(static::PATH_DRAFTS)->post($params)->toArray());
    }

    /**
     * @param $id
     * @param Draft $draft
     * @param $version
     * @return Draft
     * @throws Exception
     */
    public function updateDraft($id, Draft $draft, $version): Draft
    {
        return new Draft($this->request()->withBearerTokenAuth()->setPath(static::PATH_DRAFT, $id)->put([
            'subject' => $draft->subject,
            'to' => $draft->to,
            'cc' => $draft->cc,
            'bcc' => $draft->bcc,
            'from' => $draft->from,
            'reply_to' => $draft->reply_to,
            'reply_to_message_id' => $draft->reply_to_message_id,
            'body' => $draft->body,
            'file_ids' => $draft->file_ids,
            'version' => $version
        ])->toArray());
    }

    /**
     * @param string $id
     * @param $version
     * @return bool
     * @throws Exception
     */
    public function deleteDraft(string $id, $version): bool
    {
        return $this->request()->withBearerTokenAuth()->setPath(static::PATH_DRAFT, $id)->delete([
            'version' => $version
        ])->isSuccess();
    }

}
