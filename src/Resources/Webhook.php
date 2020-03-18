<?php

namespace Nylas\Resources;

/**
 * Class Webhook
 *
 * @property string $id A globally unique object identifier.
 * @property string $application_id A reference to the parent application object.
 * @property string $callback_url The URL where notifications are posted.
 * @property string $state The state of the webhook. See the table below for possible values.
 * @property array $triggers An array containing a set of triggers, describing the notifications this webhook should receive. See the triggers table in Creating a Webhook for possible values.
 * @property string $version A string describing the the webhook version.
 *
 * @package Nylas\Resources
 */
class Webhook extends Resource
{

}
