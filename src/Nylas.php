<?php

namespace Nylas;

use GuzzleHttp\Client as GuzzleClient;
use Nylas\Exceptions\Exception;
use Nylas\Services\Account;
use Nylas\Services\Delta;
use Nylas\Services\Files;
use Nylas\Services\Messages;
use Nylas\Services\OAuth;
use Nylas\Services\Send;
use Nylas\Services\Webhooks;

/**
 * Nylas
 *
 * @method Webhooks Webhooks()
 * @method OAuth OAuth()
 * @method Delta Delta()
 * @method Messages Messages()
 * @method Send Send()
 * @method Files Files()
 * @method Account Account()
 *
 * @author Greg Gunner <greg@co-foundry.co.za>
 * @package Nylas
 */
class Nylas
{
    const SCOPE_EMAIL_MODIFY             = 'email.modify';
    const SCOPE_EMAIL_READ_ONY           = 'email.read_only';
    const SCOPE_EMAIL_SEND               = 'email.send';
    const SCOPE_EMAIL_FOLDER_AND_LABELS  = 'email.folders_and_labels';
    const SCOPE_EMAIL_META               = 'email.metadata';
    const SCOPE_EMAIL_DRAFTS             = 'email.drafts';
    const SCOPE_CALENDAR                 = 'calendar';
    const SCOPE_CALENDAR_READ_ONLY       = 'calendar.read_only';
    const SCOPE_ROOM_RESOURCES_READ_ONLY = 'room_resources.read_only';
    const SCOPE_CONTACTS                 = 'contacts';
    const SCOPE_CONTACTS_READ_ONLY       = 'contacts.read_only';

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
    protected $httpClient;

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
     * Instantiated Services
     *
     * @var array
     */
    protected $services = [];

    /**
     * Client constructor.
     *
     * @param string $client_id
     * @param string $client_secret
     * @param string $server_uri
     * @param null $access_token
     */
    public function __construct(string $client_id, string $client_secret, $server_uri, $access_token = null)
    {
        $this->client_id = $client_id;
        $this->client_secret = $client_secret;
        $this->base_url = $server_uri;
        $this->access_token = $access_token;
        $this->httpClient = $this->createHttpClient();
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
     * @param null $access_token
     */
    public function setAccessToken($access_token): void
    {
        $this->access_token = $access_token;
    }

    /**
     * @return null
     */
    public function getAccessToken()
    {
        return $this->access_token;
    }

    /**
     * @return string|null
     */
    public function getBaseUrl(): string
    {
        return $this->base_url;
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
     * @return GuzzleClient
     */
    public function getHttpClient(): GuzzleClient
    {
        return $this->httpClient;
    }

    /**
     * Generates a request object for making a request to the Nylas API
     *
     * @return Request
     */
    public function request()
    {
        return new Request($this);
    }

    /**
     * Fetch or Instantiate a Service on demand
     *
     * Called like: $client->[ServiceName]()
     *
     * @param $name
     * @param $arguments
     * @return mixed
     * @throws Exception
     */
    public function __call($name, $arguments)
    {
        $class = '\\Nylas\\Services\\' . $name;
        if (isset($this->services[$name])) {
            return $this->services[$name];
        }
        if (class_exists($class)) {
            $this->services[$name] = new $class($this);
            return $this->services[$name];
        }
        throw new Exception(sprintf('Service %s not found', $name));
    }
}
