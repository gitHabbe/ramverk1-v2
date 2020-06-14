<?php

namespace Hab\Model;

class Location
{
    private $location;

    public function __construct()
    {
        $this->location = "";
    }

    public function setLocation(String $location)
    {
        $this->location = $location;
    }

    public function getLocation() : String
    {
        return $this->location;
    }
}
