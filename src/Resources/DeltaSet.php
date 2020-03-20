<?php

namespace Nylas\Resources;

/**
 * Class Delta
 *
 * @property string $cursor_start The start cursor
 * @property string $cursor_end The end cursor
 * @property array $deltas The deltas
 *
 * @package Nylas\Resources
 */
class DeltaSet extends Resource
{
    public function __construct($data)
    {
        $this->cursor_start = $data->cursor_start;
        $this->cursor_end = $data->cursor_end;
        $deltas = [];
        foreach ($data->deltas as $delta) {
            $deltas[] = new Delta($delta);
        }
        $this->deltas = $deltas;
    }

    /**
     * @return bool
     */
    public function hasDeltas()
    {
        return (isset($this->data['deltas']) && count($this->data['deltas']) > 0);
    }
}
