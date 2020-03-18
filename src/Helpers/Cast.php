<?php


namespace Nylas\Helpers;


class Cast
{
    /**
     * Cast the value to the given type
     *
     * This will also clean up the value to avoid incorrect castings, like "" or null to 0.
     *
     * @param $value
     * @param $cast
     * @todo add casting to date and datetime
     */
    static public function type(&$value, $cast)
    {
        if ($value === "") {
            switch ($cast) {
                case 'bool':
                case 'boolean':
                case 'int':
                case 'integer':
                case 'float':
                case 'double':
                    $value = null;
                    break;
            }

        }
        if ($value === null) {
            return;
        }
        if ($cast === 'boolean' || $cast === 'bool') {
            if ($value === 'true' || $value === true) {
                $value = true;
            } else {
                $value = false;
            }
        }
        settype($value, $cast);
    }
}
