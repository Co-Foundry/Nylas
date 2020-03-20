<?php


namespace Nylas\Resources;


use Nylas\Helpers\Cast;

abstract class Resource
{
    protected $data = [];

    protected $cast = [];

    /**
     * Resource constructor.
     * @param array|null $data
     */
    public function __construct($data = [])
    {
        if ($data) {
            $this->fill($data);
        }
    }

    public function fill($data)
    {
        foreach ($data as $key => $value) {
            $this->__set($key, $value);
        }
    }

    public function __get($name)
    {
        if (isset($this->data[$name])) {
            return $this->data[$name];
        } else {
            return null;
        }
    }

    public function __set($name, $value)
    {
        if (isset($this->cast[$name])) {
            Cast::type($value, $this->cast[$name]);
        }
        $method = 'set' . ucfirst($name);
        if (method_exists($this, $method)) {
            call_user_func([$this, $method], $value);
        } else {
            $this->data[$name] = $value;
        }
    }

    public function toArray(){
        return $this->data;
    }

    static function collection()
    {

    }
}
