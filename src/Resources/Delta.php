<?php

namespace Nylas\Resources;

/**
 * Class Delta
 *
 * @param string $cursor The cursor value for this delta.
 * @param string $object The object type of the changed object. (message, thread, etc.)
 * @param string $id The id of the changed object
 * @param string $event	The type of change. Either create, modify, or delete.
 * @param array $attributes The current state of the object. Note this may be different from the state when the delta change actually happened.
 *
 * @package Nylas\Resources
 */
class Delta extends Resource
{

}
