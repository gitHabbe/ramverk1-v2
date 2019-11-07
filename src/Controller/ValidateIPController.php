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
class ValidateIPController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;



    /**
     * @var string $res is the response of filters on selected IP
     */
    private $res;


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
     * Creates page and form for IP validation.
     * @return page
     */
    public function indexActionGet() : object
    {
        $data = [
            "res" => $this->res,
        ];
        $title = "Validate IP";
        $page = $this->di->get("page");
        $page->add("validate-ip", $data);

        return $page->render([
            "title" => $title,
        ]);
    }

    /**
     * Reads post variables and sett result in session.
     * Redirects user back to form page. (/validate)
     * @return redirect
     */
    public function checkActionPost() : object
    {
        $request = $this->di->get("request");
        $response = $this->di->get("response");
        $session = $this->di->get("session");
        $ip = $request->getPost("ip");
        $this->res[0] = $ip;
        $filterIPV4 = filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
        $filterIPV6 = filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6);
        if ($filterIPV4) {
            $this->res[1] = $ip . " is a valid IPV4 address";
            $this->res[2] = gethostbyaddr($ip);
        } elseif ($filterIPV6) {
            $this->res[1] = $ip . " is a valid IPV6 address";
            $this->res[2] = gethostbyaddr($ip);
        } else {
            $this->res[1] = $ip . " is not a valid IP address";
            $this->res[2] = "";
        }

        $session->set("res", $this->res);
        return $response->redirect("validate");
    }

    /**
     * Resets session variable's response
     * @return redirect
     */
    public function resetActionPost() : object
    {
        $response = $this->di->get("response");
        $session = $this->di->get("session");
        $this->res[1] = "";
        $session->set("res", $this->res);
        return $response->redirect("validate");
    }
}