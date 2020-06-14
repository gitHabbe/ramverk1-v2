<?php

namespace Hab\Model;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

class Fetch2 implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    private $curl;
    private $url;
    private $method;
    private $data;
    private $sweChars;

    public function __construct(String $method = "GET", String $url = "", Array $data = [])
    {
        $this->method = $method;
        $this->url = $url;
        $this->data = $data;
        $this->sweChars = [
            "å" => "a",
            "ä" => "a",
            "ö" => "o"
        ];
    }

    public function setMethod(String $method = "GET")
    {
        $this->method = $method;
    }

    public function setUrl(String $url)
    {
        $this->url = $url;
    }

    public function getMethod() : String
    {
        return $this->method;
    }

    public function fetch(String $method, String $url, Array $params = [])
    {
        $curl = curl_init();
        $url = str_replace(array_keys($this->sweChars), $this->sweChars, $url);;
        switch ($method) {
            case "GET":
                break;
            case "POST":
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                curl_setopt($curl, CURLOPT_POST, true);
                break;    
            case "PUT":
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
                break;    
            case "DELETE":
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
                break;    
            default:
                break;
        }
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $res = curl_exec($curl);
        curl_close($curl);

        return $res;
    }

    public function prep(String $method, String $url, Array $params = [])
    {
        $curl = curl_init();
        $url = str_replace(array_keys($this->sweChars), $this->sweChars, $url);;
        switch ($method) {
            case "GET":
                break;
            case "POST":
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                curl_setopt($curl, CURLOPT_POST, true);
                break;    
            case "PUT":
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
                break;    
            case "DELETE":
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
                break;    
            default:
                break;
        }
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        return $curl;
    }

    public function exec($curl)
    {
        $res = curl_exec($curl);
        curl_close($curl);

        return $res;
    }

    public function multiFetch(Array $urls = [])
    {
        $temp = [];
        foreach ($urls as $url) {
            var_dump($url);
            $asdf = $this->fetch("GET", $url);
            var_dump($asdf);
            die();
            // array_push($temp, $this->fetch("GET", $url));
        }
        return $temp;
    }

    // public function multiFetch($urls = [])
    // {
    //     $mc = curl_multi_init();
    //     $curls = [];
    //     foreach ($urls as $url) {
    //         // var_dump($urls);
    //         // die();
    //         $curl = $this->prep($url[0], $url[1], $url[2]);
    //         curl_multi_add_handle($mc, $curl);
    //         array_push($curls, $curl);
    //     }
    //     do {
    //         $status = curl_multi_exec($mc, $active);
    //         if ($active) {
    //             curl_multi_select($mc);
    //         }
    //     } while ($active && $status == CURLM_OK);
    //     foreach ($curls as $curl) {
    //         curl_multi_remove_handle($mc, $curl);
    //     }
    //     curl_multi_close($mc);

    //     return $mc;
    // }
}
