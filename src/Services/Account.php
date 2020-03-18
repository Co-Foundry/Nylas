<?php

namespace Nylas\Services;

use Nylas\Exceptions\Exception;

class Account extends Service
{
    const URI = '/account';

    /**
     * Get one webhook
     *
     * @param $id
     * @return mixed
     * @throws Exception
     */
    public function getAccount()
    {
        return $this->client->call(self::URI);
    }

}
