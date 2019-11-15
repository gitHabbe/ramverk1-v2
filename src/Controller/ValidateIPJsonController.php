<?php

namespace Anax\Controller;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

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
class ValidateIPJsonController implements ContainerInjectableInterface
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



    /**
     * Takes string from GET query.
     * Calculates if string is valid ipv4/ipv6 address
     * and if there is a host attached to it.
     * Returns response as JSON.
     * @return array
     */
    public function indexActionGet() : array
    {
        $request = $this->di->get("request");
        $ip = $request->getGet("ip", "");
        
        $validator = new \Hab\Model\ValidateIP($ip);
        $data = $validator->sendRes();
        $this->res["data"] = $data;

        return [$this->res];
    }
}
