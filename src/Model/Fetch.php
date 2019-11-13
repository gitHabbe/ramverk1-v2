<?php

class Fetch
{
    private $curl;
    private $url;
    private $method;
    private $data;

    public function __construct(String $url = "localhost:8080", String $method = "GET", Array $data = []) {
        $this->curl = curl_init();
        $this->url = $url;
        $this->method = $method;
        $this->data = $data;
    }

    public function applyMethod(String $method)
    {
        switch ($method) {
            case "GET":
                # code...
                break;
            
            default:
                # code...
                break;
        }
    }
}
