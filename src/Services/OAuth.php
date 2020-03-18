<?php


namespace Nylas\Services;

use Nylas\Exceptions\Exception;
use Nylas\Services\Service;

class OAuth extends Service
{
    const URI_AUTH = '/oauth/authorize';
    const URI_TOKEN = '/oauth/token';
    const URI_REVOKE = '/oauth/revoke';

    /**
     * Get the authorization URL
     *
     * @param string $redirect_uri
     * @param string $response_type 'code' for server side and for storing  or 'token' for client side
     * @param array $scopes
     * @param string|null $login_hint
     * @return string
     */
    public function getAuthorizeUrl(string $redirect_uri, string $response_type = 'code', array $scopes = [], string $login_hint = null)
    {
        $args = array(
            "client_id" => $this->client->getClientId(),
            "redirect_uri" => $redirect_uri,
            "response_type" => $response_type,
            "scopes" => implode(',', $scopes),
            "login_hint" => $login_hint
        );

        return self::URI_AUTH . '?' . http_build_query($args);
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
            'grant_type' => 'authorization_code',
            'code' => $code
        ];
        return $this->client->call(static::URI_TOKEN, 'POST', $args);
    }
}
