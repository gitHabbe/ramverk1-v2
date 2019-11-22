<?php

namespace Anax\Controller;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Hab\Model;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 * The controller will be injected with $di if implementing the interface
 * ContainerInjectableInterface, like this sample class does.
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class GeoJSONController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;



    /**
     * @var string $res is the response of filters on selected IP
     */
    private $res = [];


    /**
     * The initialize method is optional and will always be called before the
     * target method/action. This is a convienient method where you could
     * setup internal properties that are commonly used by several methods.
     *
     * @return void
     */
    public function initialize() : void
    {
        // Use to initialise member variables.
        $this->res = [];
    }

    public function searchActionPost()
    {
        $request = $this->di->get("request");
        $ip = $request->getPost("ip");
        $validator = new \Hab\Model\ValidateIP($ip);
        $data = $validator->sendRes();
        if ($data["isValid"]) {
            $api = require(ANAX_INSTALL_PATH . "/config.php");
            $key = $api["key"];
            $fetch = new \Hab\Model\Fetch("GET", "http://api.ipstack.com/$ip?access_key=$key");
            $res = $fetch->fetch();
        }
        return [$res];
    }

    public function searchActionGet()
    {
        $request = $this->di->get("request");
        $ip = $request->getGet("ip");
        $validator = new \Hab\Model\ValidateIP($ip);
        $data = $validator->sendRes();
        if ($data["isValid"]) {
            $api = require(ANAX_INSTALL_PATH . "/config.php");
            $key = $api["key"];
            $fetch = new \Hab\Model\Fetch("GET", "http://api.ipstack.com/$ip?access_key=$key");
            $res = $fetch->fetch();
        }
        return [$res];
    }
}
