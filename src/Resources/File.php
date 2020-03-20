<?php

namespace Nylas\Resources;

use Carbon\Carbon;

/**
 * Class Draft
 *
 * @property string $id A globally unique object identifier.
 * @property string $object A string describing the type of object (value is "file").
 * @property string $account_id Reference to a parent account object.
 * @property string $filename The name of the file
 * @property int $size The size of the file
 * @property string $content_type The content type
 * @property array $message_ids An array of message ids the file is attached to
 * @property string $content_id
 * @package Nylas\Resources
 */
class File extends Resource
{

}
