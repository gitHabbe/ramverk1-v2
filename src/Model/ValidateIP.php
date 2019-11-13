<?php

namespace Hab\Model;

class ValidateIP
{
    private $ip;

    public function __construct($ip = "")
    {
        $this->ip = $ip;
    }

    public function setIP(String $ip = "") : void
    {
        $this->ip = $ip;
    }

    public function getIP() : String
    {
        return $this->ip;
    }

    public function validateIPV4(String $ip)
    {
        return filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
    }

    public function validateIPV6(String $ip)
    {
        return filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6);
    }

    public function getHost(String $ip)
    {
        return gethostbyaddr($ip);
    }

    public function isValidIP(String $ip)
    {
        if ($this->validateIPV4($ip)) { return "ipv4"; }
        if ($this->validateIPV6($ip)) { return "ipv6"; }
        return false;

    }

    public function sendRes(String $ip)
    {
        if (!$this->isValidIP($ip)) {
            return false;
        }
        return [
            "ip" => $ip,
            "type" => $this->isValidIP($ip),
            "host" => $this->getHost($ip),
        ];
    }
}
