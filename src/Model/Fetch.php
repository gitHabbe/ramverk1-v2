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

    public function __construct(String $url = "localhost:8080", String $method = "GET", Array $data = []) {
        $this->curl = curl_init();
        $this->url = $url;
        $this->method = $method;
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
        $post = $this->di->get("request")->getPost();
        switch ($this->getMethod()) {
            case "POST":
            case "PUT":
            case "DELETE":
                curl_setopt($this->curl, CURLOPT_POSTFIELDS, $data);
                break;
            
            default:
                # code...
                break;
        }
    }
}
