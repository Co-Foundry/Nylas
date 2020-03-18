<?php

namespace Nylas\Services;

use Nylas\Exceptions\Exception;

class Connect extends Service
{
    const URI_AUTH = '/connect/authorize';
    const URI_TOKEN = '/connect/token';

    public function authorize(string $name, string $email, string $provider, array $settings, array $scopes)
    {
        $args = array(
            "client_id" => $this->client->getClientId(),
            "name" => $name,
            "email" => $email,
            "provider" => $provider,
            "settings" => $settings,
            "scopes" => implode(',', $scopes)
        );

        return $this->client->call(self::URI_AUTH, 'POST', $args);
    }

    /**
     * Get the token for a given code
     *
     * @param $code
     * @return mixed
     * @throws Exception
     */
    public function getToken($code)
    {
        $args = [
            "client_id" => $this->client->getClientId(),
            "client_secret" => $this->client->getClientSecret(),
            'code' => $code
        ];
        return $this->client->call(static::URI_TOKEN, 'POST', $args);
    }
}
