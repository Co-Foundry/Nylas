<?php

namespace Nylas;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Response;
use Nylas\Exceptions\Exception;
use Nylas\Services\Webhooks;

/**
 * Class Client
 *
 * @method Webhooks Webhooks()
 * @package Nylas
 */
class Client
{
    const SCOPE_EMAIL_MODIFY = 'email.modify';
    const SCOPE_EMAIL_READ_ONY = 'email.read_only';
    const SCOPE_EMAIL_SEND = 'email.send';
    const SCOPE_EMAIL_FOLDER_AND_LABELS = 'email.folders_and_labels';
    const SCOPE_EMAIL_META = 'email.metadata';
    const SCOPE_EMAIL_DRAFTS = 'email.drafts';
    const SCOPE_CALENDAR = 'calendar';
    const SCOPE_CALENDAR_READ_ONLY = 'calendar.read_only';
    const SCOPE_ROOM_RESOURCES_READ_ONLY = 'room_resources.read_only';
    const SCOPE_CONTACTS = 'contacts';
    const SCOPE_CONTACTS_READ_ONLY = 'contacts.read_only';

    /**
     * Nylas base url
     *
     * @var string|null
     */
    protected $base_url;

    /**
     * HTTP client
     *
     * @var GuzzleClient
     */
    protected $http;

    /**
     * Client ID provided by Nylas
     *
     * @var
     */
    private $client_id;

    /**
     * Client Secret provided by Nylas
     * @var
     */
    private $client_secret;

    /**
     * User Email account authorization token
     *
     * @var null
     */
    protected $access_token;

    /**
     * Client constructor.
     *
     * @param string $client_id
     * @param string $client_secret
     * @param null $access_token
     */
    public function __construct(string $client_id, string $client_secret, $access_token = null)
    {
        $this->client_id = $client_id;
        $this->client_secret = $client_secret;
        $this->base_url = 'https://api.nylas.com/';
        $this->access_token = $access_token;
        $this->http = $this->createHttpClient();
    }

    /**
     * @return mixed
     */
    public function getClientId()
    {
        return $this->client_id;
    }

    /**
     * @return mixed
     */
    public function getClientSecret()
    {
        return $this->client_secret;
    }

    /**
     * Generate API header
     *
     * @return array
     */
    protected function createHeaders()
    {
        $token = 'Basic ' . base64_encode($this->access_token . ':');
        $headers = array('headers' => [
            'Authorization' => $token,
            'X-Nylas-API-Wrapper' => 'php'
        ]);

        return $headers;
    }

    /**
     * Create new Http client
     *
     * @return GuzzleClient
     */
    protected function createHttpClient()
    {
        return new GuzzleClient([
            'base_uri' => $this->base_url
        ]);
    }

    /**
     * @param string $path
     * @param string $method
     * @param null $payload
     * @param array $options
     * @param boolean $stream
     * @return mixed
     * @throws Exception
     */
    public function call(string $path, $method = 'GET', $payload = null, $options = [], $stream = false)
    {

        $path = '/a/' . $this->client_id . $path;

        $defaults = [
            'verify' => false,
            'headers' => [
                'Cache-Control' => 'no-cache',
                'Content-Type' => 'application/json',
                'Authorization' => 'Basic ' . base64_encode($this->getClientSecret() . ':')
            ]
        ];

        if ($method === 'GET') {
            $options = array_merge_recursive($defaults, $options, [
                'query' => $payload,
            ]);
        } elseif ($payload) {
            $options = array_merge($defaults, $options, [
                'body' => json_encode($payload),
            ]);
        }

        /** @var Response $response */
        try {
            $response = $this->http->request($method, $path, $options);
        } catch (ClientException $e) {
            $response = $e->getResponse();
            throw $this->exception($response);
        }

        if ($stream) {
            return $response->getBody();
        } else {
            return json_decode((string) $response->getBody());
        }
    }

    /**
     * @param Response $response
     * @return Exception
     */
    protected function exception(Response $response)
    {
        $code = $response->getStatusCode();
        $body = (array) json_decode((string) $response->getBody());

        $message = isset($body['message']) ? $body['message'] : 'Unknown Error';
        $type = isset($body['type']) ? $body['type'] : 'Unknown Type';

        /** @var Exception $exception */
        $exception = Exception::getExceptionClass($code);

        return (new $exception($message, $code))->setType($type);
    }

    /**
     * Will instantiated a Service
     *
     * Call the client like: $client->[ServiceName]()
     *
     * @param $name
     * @param $arguments
     * @return mixed
     * @throws Exception
     */
    public function __call($name, $arguments)
    {
        $class = '\\Nylas\\Services\\' . $name;
        if (class_exists($class)) {
            return new $class($this);
        }
        throw new Exception(sprintf('Service %s not found', $name));
    }
}
