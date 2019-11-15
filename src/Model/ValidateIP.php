<?php

namespace Hab\Model;

class ValidateIP
{
    private $ip;
    private $type;

    public function __construct($ip = "")
    {
        $this->ip = $ip;
        $this->type = "unknown";
    }

    public function setIP(String $ip = "") : void
    {
        $this->ip = $ip;
    }

    public function getIP() : String
    {
        return $this->ip;
    }

    public function setType(String $type)
    {
        $this->type = $type;
    }

    public function getType() : String
    {
        return $this->type;
    }

    public function validateIPV4(String $ip)
    {
        return filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
    }

    public function validateIPV6(String $ip)
    {
        return filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6);
    }

    public function getHost()
    {
        return gethostbyaddr($this->ip);
    }

    public function validate()
    {
        if ($this->validateIPV4($this->ip)) {
            $this->setType("ipv4");
            return true;
        }
        if ($this->validateIPV6($this->ip)) {
            $this->setType("ipv6");
            return true;
        }
        return false;
    }

    public function sendRes()
    {
        $res = [];
        if (!$this->validate()) {
            $res["text"] = $this->ip . " is not a valid format";
        } else {
            $res["text"] = $this->ip . " is a valid " . $this->getType() . " adress";
        }
        $res["ip"] = $this->getIP();
        $res["host"] = $this->getHost();
        $res["type"] = $this->getType();
        return $res;
    }
}
