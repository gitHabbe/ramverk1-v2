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
class GeoController implements ContainerInjectableInterface
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
        $session = $this->di->get("session");
        if ($session->get("res")) {
            $this->res = $session->get("res");
        }
    }



    /**
     * Creates page and form for GEO.
     * @return page
     */
    public function indexActionGet() : object
    {
        $request    = $this->di->get("request");
        $page       = $this->di->get("page");

        $defaultIP = $request->getServer("HTTP_X_FORWARDED_FOR") ? $request->getServer("HTTP_X_FORWARDED_FOR") : "45.144.116.1";
        $data = [
            "res" => $this->res,
            "defaultIP" => $defaultIP,
        ];
        $title = "Validate IP";
        $page->add("geo-ip", $data);

        return $page->render(["title" => $title]);
    }

    public function searchActionPost()
    {
        $response = $this->di->get("response");
        $request = $this->di->get("request");
        $session = $this->di->get("session");
        $ip = $request->getPost("ip");
        $validator = new \Hab\Model\ValidateIP($ip);
        $data = $validator->sendRes();
        if ($data["isValid"]) {
            $api = require(ANAX_INSTALL_PATH . "/config.php");
            $key = $api["key"];
            $fetch = new \Hab\Model\Fetch("GET", "http://api.ipstack.com/$ip?access_key=$key");
            $this->res["fetch"] = json_decode($fetch->fetch());
        }
        $this->res["data"] = $data;
        $session->set("res", $this->res);

        return $response->redirect("geo");
    }

    /**
     * Resets session variable's response
     * @return redirect
     */
    public function resetActionPost() : object
    {
        $response = $this->di->get("response");
        $session = $this->di->get("session");
        $this->res = [];
        $session->set("res", $this->res);

        return $response->redirect("geo");
    }
}
