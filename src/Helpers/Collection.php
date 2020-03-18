<?php


namespace Nylas\Helpers;

use Nylas\Client;
use Nylas\Exceptions\Exception;

/**
 * Class Collection
 *
 * A collection is an API wrapper for fetching a series of results from the api, such as a list of users or products
 *
 * @package Nylas\Helpers
 */
class Collection
{

    /**
     * @var int The size of the results to return
     */
    private $chunk_size = 50;

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var string The path to call for this collection
     */
    protected $path;

    /**
     * @var string
     */
    protected $resource;

    /**
     * @var array The filters to apply to the call
     */
    protected $filters = [];

    /**
     * Collection constructor.
     * @param Client $client The client to use
     * @param string $path The url path to call
     * @param string $resource The Resource class to return the items returned by the API
     */
    public function __construct(Client $client, string $path, string $resource)
    {
        $this->client = $client;
        $this->path = $path;
        $this->resource = $resource;
    }

    /**
     * @param int $offset
     * @return \Generator
     * @throws Exception
     */
    public function items($offset = 0)
    {
        while (true) {
            $items = $this->call($offset, $this->chunk_size);
            if (empty($items)) {
                break;
            }
            foreach ($items as $item) {
                yield new ($this->resource)($item);
            }
            if (count($items) < $this->chunk_size) {
                break;
            }
        }
    }

    /**
     * Adds filters to the collection call
     *
     * @param $filters
     * @return $this
     */
    public function where($filters)
    {
        $this->filters = array_merge($this->filters, $filters);
        return $this;
    }

    /**
     * Calls the api to get the collection data
     *
     * @param int $offset
     * @param int $limit
     * @return mixed
     * @throws Exception
     */
    protected function call($offset, $limit)
    {
        $filters = array_merge($this->filters, [
            'limit' => $limit,
            'offset' => $offset
        ]);

        return $this->client->call($this->path, 'GET', $filters);
    }
}
