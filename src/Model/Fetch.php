<?php

namespace Hab\Model;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

class Fetch implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    private $curl;
    private $url;
    private $method;
    private $data;

    public function __construct(String $method, String $url, Array $data = [])
    {
        $this->curl = curl_init();
        $this->method = $method;
        $this->url = $url;
        $this->data = $data;
    }

    public function setMethod(String $method = "GET")
    {
        $this->method = $method;
    }

    public function getMethod() : String
    {
        return $this->method;
    }

    public function applyMethod(String $method)
    {
        switch ($method) {
            case "GET":
                $this->setMethod("GET");
                return "GET";
            case "POST":
                curl_setopt($this->curl, CURLOPT_POST, true);
                $this->setMethod("POST");
                return "POST";
            case "PUT":
                curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, "PUT");
                $this->setMethod("PUT");
                return "PUT";
            case "DELETE":
                curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, "DELETE");
                $this->setMethod("DELETE");
                return "DELETE";
            default:
                return false;
        }
    }

    public function applyParams(Array $data = [])
    {
        // $post = $this->di->get("request")->getPost();
        switch ($this->getMethod()) {
            case "POST":
            case "PUT":
            case "DELETE":
                curl_setopt($this->curl, CURLOPT_POSTFIELDS, $data);
                break;
        }
    }

    public function fetch()
    {
        curl_setopt($this->curl, CURLOPT_URL, $this->url);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
        $res = curl_exec($this->curl);
        curl_close($this->curl);
        return $res;
    }
}
