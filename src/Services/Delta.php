<?php

namespace Nylas\Services;

use Nylas\Exceptions\Exception;
use Nylas\Resources\DeltaSet;

/**
 * Class Delta
 *
 * @author Greg Gunner <greg@co-foundry.co.za>
 * @package Nylas\Services
 */
class Delta extends Service
{
    const PATH_DELTA = '/delta';
    const PATH_DELTA_LATEST_CURSOR = '/delta/latest_cursor';

    /**
     * Get the latest cursor
     *
     * @return string
     * @throws Exception
     */
    public function getLatestCursor()
    {
        return $this->request()
            ->withBasicTokenAuth()
            ->setPath(self::PATH_DELTA_LATEST_CURSOR)
            ->post()
            ->toJson()
            ->cursor
        ;
    }

    /**
     * Get a set of Deltas from a given cursor
     *
     * @param $cursor
     * @param string|null $view
     * @param array|null $exclude_types
     * @param array|null $include_types
     * @return DeltaSet
     * @throws Exception
     */
    public function getDeltas($cursor, string $view = null, ?array $exclude_types = null, ?array $include_types = null)
    {
        return new DeltaSet(
            $this->request()
                ->withBasicTokenAuth()
                ->setPath(self::PATH_DELTA)
                ->get([
                    'cursor' => $cursor,
                    'view' => $view,
                    'exclude_types' => ($exclude_types) ? implode(',', $exclude_types) : null,
                    'include_types' => ($include_types) ? implode(',', $include_types) : null
                ])
                ->toJson()
        );
    }


}
