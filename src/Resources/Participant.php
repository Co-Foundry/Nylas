<?php


namespace Nylas\Resources;


class Participant
{

    protected $data = [];

    public function __construct($email, $name = null)
    {
        $this->data['email'] = $email;
        if ($name) {
            $this->data['name'] = $name;
        }
    }

    public function toArray()
    {
        return $this->data;
    }

}
