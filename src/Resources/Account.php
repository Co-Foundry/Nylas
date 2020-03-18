<?php

namespace Nylas\Resources;

/**
 * Class Account
 *
 * @property string $id A globally unique object identifier.
 * @property string $object A string describing the type of object (value is "account").
 * @property string $account_id A reference to the parent account object (self-referential in this case).
 * @property string $name The full name of the user, used as the default "from" name when sending mail.
 * @property string $email_address The canonical email address of the account. For Gmail accounts, this removes periods and plus suffixes.
 * @property string $provider Specifies the provider that backs the account (e.g. gmail or eas). See Supported Providers for a full list.
 * @property string $organization_unit Specify either "label" or "folder", depending on the provider capabilities.
 * @property string $sync_state The syncing status of the account. See the Sync status documentation for possible values.
 * @property int $linked_at A Unix timestamp indicating when this account was originally connected to Nylas.
 * @package Nylas\Resources
 */
class Account extends Resource
{

}
