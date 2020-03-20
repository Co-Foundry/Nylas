<?php

namespace Nylas\Helpers;

use Nylas\Exceptions\Exception;
use Nylas\Request;

/**
 * Collection
 *
 * A collection is an API wrapper for fetching a series of results from the api, such as a list of users or products
 *
 * @author Greg Gunner <greg@co-foundry.co.za>
 * @package Nylas\Helpers
 */
class Collection
{
    /**
     * @var Request
     */
    protected $request;

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
     * @param Request $request A request object
     * @param string $resource The Resource class to return the items returned by the API
     */
    public function __construct(Request $request, string $resource)
    {
        $this->request = $request;
        $this->resource = $resource;
    }

    /**
     * Get the items
     *
     * This will continue to call the api until either there are not more items in the set, or
     * the set has been reached
     *
     * @param int $offset
     * @param int $limit
     * @return \Generator
     * @throws Exception
     */
    public function items($offset = 0, $limit = 50)
    {
        while (true) {
            $items = $this->get($offset, $limit)->toJson();
            if (empty($items)) {
                break;
            }
            foreach ($items as $item) {
                yield $this->toResource($item);
            }
            break;
        }
    }

    /**
     * Converts the given data to the collection resource
     *
     * @param $item
     * @return mixed
     */
    public function toResource($item)
    {
        return new $this->resource($item);
    }

    /**
     * @return null
     * @throws Exception
     */
    public function first()
    {
        $item = $this->get(0, 1)->toJson();
        if (!empty($item)) {
            return new $this->resource($item);
        } else {
            return null;
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
     * @return Request
     * @throws Exception
     */
    protected function get($offset, $limit)
    {
        $filters = array_merge($this->filters, [
            'limit' => $limit,
            'offset' => $offset
        ]);
        return $this->request->setParams($filters)->call();
    }

    /**
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->request;
    }
}
