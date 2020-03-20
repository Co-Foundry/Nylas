<?php

namespace Nylas\Services;

use Nylas\Exceptions\Exception;

/**
 * Class OAuth
 *
 * @author Greg Gunner <greg@co-foundry.co.za>
 * @package Nylas\Services
 */
class OAuth extends Service
{
    const PATH_AUTH = '/oauth/authorize';
    const PATH_TOKEN = '/oauth/token';
    const PATH_REVOKE = '/oauth/revoke';

    /**
     * Get the authorization URL
     *
     * @param string $redirect_uri
     * @param string $state
     * @param array $scopes
     * @param string|null $login_hint
     * @param string $response_type 'code' for server side and for storing  or 'token' for client side
     * @return string
     */
    public function getAuthorizeUrl(string $redirect_uri, string $state, array $scopes = [], string $login_hint = null, string $response_type = 'code')
    {
        $args = array(
            "client_id" => $this->nylas->getClientId(),
            "redirect_uri" => $redirect_uri,
            "response_type" => $response_type,
            "scopes" => implode(',', $scopes),
            "login_hint" => $login_hint,
            'state' => $state
        );

        return $this->nylas->getBaseUrl() . self::PATH_AUTH . '?' . http_build_query($args);
    }

    /**
     * Get the token for a given code
     *
     * @param $code
     * @return \stdClass
     * @throws Exception
     */
    public function getToken($code)
    {
        $args = [
            "client_id" => $this->nylas->getClientId(),
            "client_secret" => $this->nylas->getClientSecret(),
            'grant_type' => 'authorization_code',
            'code' => $code
        ];
        return $this->request()->setPath(static::PATH_TOKEN)->post($args)->toJson();
    }

    /**
     * Get the token for a given code
     *
     * @return boolean
     * @throws Exception
     */
    public function revokeToken()
    {
        return $this->request()
            ->withBearerTokenAuth()
            ->setPath(static::PATH_REVOKE)
            ->post()
            ->isSuccess()
        ;
    }

}
