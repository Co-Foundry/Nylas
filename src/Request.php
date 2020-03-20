<?php

namespace Nylas;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Response;
use Nylas\Exceptions\Exception;
use Psr\Http\Message\StreamInterface;
use stdClass;

/**
 * Request
 *
 * A Request represents a configured Request to be made against the Nylas API
 *
 * By default, each Request object is created using withBasicClientAuth
 *
 * @author Greg Gunner <greg@co-foundry.co.za>
 * @package Nylas
 */
class Request
{

    /**
     * @var Nylas
     */
    protected $nylas;

    /**
     * @var string
     */
    protected $content_type = 'application/json';

    /**
     * @var array
     */
    protected $headers = [];

    /**
     * @var string
     */
    protected $base_path;

    /**
     * @var string
     */
    protected $method = 'GET';

    /**
     * @var string
     */
    protected $path = '/';

    /**
     * @var array
     */
    protected $params = [];

    /**
     * @var string
     */
    protected $body;

    /**
     * @var Response
     */
    protected $response;

    /**
     * @var array Default options for Guzzle
     */
    protected $defaults = [
        'verify' => false,
        'headers' => [
            'Cache-Control' => 'no-cache',
            'X-Nylas-API-Wrapper' => 'php'
        ]
    ];

    /**
     * Request constructor.
     * @param Nylas $nylas
     */
    public function __construct(Nylas $nylas)
    {
        $this->nylas = $nylas;
        $this->withBasicClientAuth();
    }

    /**
     * Set the request method
     *
     * @param string $method
     * @return $this
     */
    public function setMethod(string $method)
    {
        $this->method = $method;
        return $this;
    }

    /**
     * Get the request method
     *
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * Set the Content-Type header
     *
     * @param string $content_type
     * @return $this
     */
    public function setContentType(string $content_type)
    {
        $this->content_type = $content_type;
        return $this;
    }

    /**
     * Get the Content-Type header
     *
     * @return string
     */
    public function getContentType(): string
    {
        return $this->content_type;
    }

    /**
     * Set a Header value
     *
     * @param string $key
     * @param string $value
     * @return $this
     */
    public function setHeader($key, $value)
    {
        $this->headers[$key] = $value;
        return $this;
    }

    /**
     * Get the headers
     *
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * Get a specific header
     *
     * @param $key
     * @param null $default
     * @return mixed|null
     */
    public function getHeader($key, $default = null)
    {
        if (isset($this->headers[$key])) {
            return $this->headers[$key];
        } else {
            return $default;
        }
    }

    /**
     * Set the request path
     *
     * With Nylas the requested path can change or have additional parts, like with webhooks
     *
     * This should be just the path give for the specific call being made
     *
     * Additions to the path, such as that in the webhooks, should use methods like withClientId().
     *
     * @param mixed $path
     * @return $this
     */
    public function setPath($path)
    {
        $this->path = $path;
        return $this;
    }

    /**
     * Get the path
     *
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * Get the full path
     *
     * @return string
     */
    public function getFullPath(): string
    {
        return $this->base_path . $this->path;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * @param mixed $params
     * @return $this
     */
    public function setParams($params)
    {
        $this->params = $params;
        return $this;
    }

    /**
     * @param string $body
     * @return $this
     */
    public function setBody(string $body)
    {
        $this->body = $body;
        return $this;
    }

    /**
     * @return string
     */
    public function getBody(): ?string
    {
        return $this->body;
    }

    /**
     * Attach the Basic Client 'Authorization' Header
     *
     * @return $this
     */
    public function withBasicClientAuth()
    {
        $this->setHeader('Authorization', 'Basic ' . base64_encode($this->nylas->getClientSecret() . ':'));
        return $this;
    }

    /**
     * Attach the Basic Token 'Authorization' Header
     *
     * @return $this
     */
    public function withBasicTokenAuth()
    {
        $this->setHeader('Authorization', 'Basic ' . base64_encode($this->nylas->getAccessToken() . ':'));
        return $this;
    }

    /**
     * Attach the Bearer Token 'Authorization' Header
     *
     * @return $this
     */
    public function withBearerTokenAuth()
    {
        $this->setHeader('Authorization', 'Bearer ' . $this->nylas->getAccessToken());
        return $this;
    }

    /**
     * Attach the client ID to the path
     *
     * @return $this
     */
    public function withClientId()
    {
        $this->base_path = '/a/' . $this->nylas->getClientId();
        return $this;
    }

    /**
     * @return $this
     * @throws Exception
     */
    public function call()
    {
        $path = $this->getFullPath();

        $options = array_merge_recursive($this->defaults, [
            'headers' => array_merge($this->getHeaders(), [
                'Content-Type' => $this->getContentType()
            ])
        ]);

        if ($this->method === 'GET' && $this->params) {
            $path = $path . '?' . http_build_query($this->params);
        } elseif ($this->params) {
            $options = array_merge($options, [
                'body' => json_encode($this->params),
            ]);
        } elseif ($this->body) {
            $options = array_merge($options, [
                'body' => $this->body,
            ]);
        }

        /** @var Response $response */
        try {
            $this->response = $this->nylas->getHttpClient()->request($this->method, $path, $options);
        } catch (ClientException $e) {
            $this->response = $e->getResponse();
            throw $this->exception($this->response);
        }
        return $this;
    }

    /**
     * Call with GET
     *
     * @param array $params
     * @return $this
     * @throws Exception
     */
    public function get($params = [])
    {
        return $this->setMethod('GET')->setParams($params)->call();
    }

    /**
     * Call with POST
     *
     * @param array $params
     * @return $this
     * @throws Exception
     */
    public function post($params = [])
    {
        return $this->setMethod('POST')->setParams($params)->call();
    }

    /**
     * Call with PUT
     *
     * @param array $params
     * @return $this
     * @throws Exception
     */
    public function put($params = [])
    {
        return $this->setMethod('PUT')->setParams($params)->call();
    }

    /**
     * Call with DELETE
     *
     * @param array $params
     * @return $this
     * @throws Exception
     */
    public function delete($params = [])
    {
        return $this->setMethod('DELETE')->setParams($params)->call();
    }

    /**
     * Convert the response to a json object
     *
     * @return stdClass Json object of the response
     */
    public function toJson()
    {
        return json_decode((string) $this->response->getBody());
    }

    /**
     * Convert the response to an array
     *
     * @return array
     */
    public function toArray()
    {
        return json_decode((string) $this->response->getBody(), true);
    }

    /**
     * Convert the response to a StreamInterface Object
     *
     * @return StreamInterface
     */
    public function toStream()
    {
        return $this->response->getBody();
    }

    /**
     * Returns if the call was a success
     *
     * This is used when there is no response expected
     *
     * @return bool
     */
    public function isSuccess()
    {
        return $this->response->getStatusCode() === 200;
    }

    /**
     * Get the response returned
     *
     * @return Response
     */
    public function getResponse(): ?Response
    {
        return $this->response;
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
}
