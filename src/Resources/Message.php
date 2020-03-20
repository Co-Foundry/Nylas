<?php

namespace Nylas\Resources;

use Carbon\Carbon;

/**
 * Class Message
 *
 * @property string $id A globally unique object identifier.
 * @property string $object A string describing the type of object (value is "message").
 * @property string $account_id Reference to a parent account object.
 * @property string $thread_id Reference to a parent thread object (all messages have a thread).
 * @property string $subject The subject line of the message.
 * @property array $from A list of name+email pairs the message was sent from. This is usually one object, but can be many.
 * @property array $to An array of name+email pairs the message was sent to.
 * @property array $cc An array of name+email pairs the message was cc'd to.
 * @property array $bcc An array of name+email pairs the message was bcc'd to. For received mail this is nearly always empty (for obvious reasons).
 * @property array $reply_to An array of name+email pairs replies should be sent to.
 * @property integer $date A timestamp of the date the message was received by the mail server. Note: This may be different from the unverified Date header in raw message object.
 * @property boolean $unread Indicates the message is unread. This is the default for new incoming mail (mutable).
 * @property boolean $starred Indicates the message is in a starred or flagged state (mutable).
 * @property string $snippet A shortened plain-text preview of the message body.
 * @property string $body The full HTML message body. Messages with only plain-text representations are up-converted to HTML.
 * @property array $files An array of File objects, if the message includes attachments.
 * @property array $events An array Event objects, if message includes calendar invites.
 * @property object $folder A single folder object indicating the location of the message. This is present only if the parent account's organization_unit is folder. This property can be changed to move the message to a different folder.
 * @property array $labels A list of Label objects. This is present only if the parent account's organization_unit is label. These have Gmail-style semantics and can be arbitrarily added and removed from messages.
 * @package Nylas\Resources
 */
class Message extends Resource
{

    public function setDate($value)
    {
        $this->data['date'] = Carbon::createFromTimestampUTC($value);
    }
}
