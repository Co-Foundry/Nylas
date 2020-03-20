<?php

namespace Nylas\Services;

use Nylas\Exceptions\Exception;
use Nylas\Resources\Account as AccountResource;

class Account extends Service
{
    const URI = '/account';

    /**
     * @return AccountResource
     * @throws Exception
     */
    public function getAccount()
    {
        return new AccountResource($this->request()->withBearerTokenAuth()->setPath(self::URI)->get()->toJson());
    }

}
