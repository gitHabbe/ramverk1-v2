<?php

namespace Anax\Controller;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Test the SampleJsonController.
 */
class ValidateIPControllerTest extends TestCase
{
    
    // Create the di container.
    protected $di;
    protected $controller;



    /**
     * Prepare before each test.
     */
    protected function setUp()
    {
        global $di;

        // Setup di
        $this->di = new DIFactoryConfig();
        $this->di->loadServices(ANAX_INSTALL_PATH . "/config/di");

        // Use a different cache dir for unit test
        $this->di->get("cache")->setPath(ANAX_INSTALL_PATH . "/test/cache");

        // View helpers uses the global $di so it needs its value
        $di = $this->di;

        // Setup the controller
        $this->controller = new ValidateIPController();
        $this->controller->setDI($this->di);
        $this->controller->initialize();
    }



    /**
     * Test if body loaded.
     */
    public function testIndexAction()
    {
        global $di;

        // Setup di
        $di = new DIFactoryConfig();
        $di->loadServices(ANAX_INSTALL_PATH . "/config/di");

        // Use a different cache dir for unit test
        $di->get("cache")->setPath(ANAX_INSTALL_PATH . "/test/cache");

        // View helpers uses the global $di so it needs its value
        // $di = $this->di;

        // Setup the controller
        $controller = new ValidateIPController();
        $controller->setDI($this->di);
        $controller->initialize();

        // Get response
        $res = $controller->indexActionGet();
        $exp = "Validate IP";
        $body = $res->getBody();

        $this->assertContains($exp, $body);
    }

    /**
     * Test validate ipv4 adress.
     */
    public function testCheckActionPostIP4Happy()
    {
        global $di;

        // Setup di
        $di = new DIFactoryConfig();
        $di->loadServices(ANAX_INSTALL_PATH . "/config/di");

        // Use a different cache dir for unit test
        $di->get("cache")->setPath(ANAX_INSTALL_PATH . "/test/cache");

        // View helpers uses the global $di so it needs its value
        // $di = $this->di;

        // Setup the controller
        $controller = new ValidateIPController();
        $controller->setDI($this->di);
        $controller->initialize();
        $session = $di->get("session");

        // Setup post request
        // Can't properly set POST variable for som reason. Is this intentional?
        // Also don't know why I have to reference $di with $this keyword.
        // $this->di->get("request")->setPost("ip", "1.2.3.4");
        $this->di->get("request")->setGlobals(["post" => ["ip" => "1.2.3.4"]]);

        // Get response
        $controller->checkActionPost();
        $res = $session->get("res");
        $exp = "1.2.3.4 is a valid IPV4 address";

        $this->assertContains($exp, $res[1]);
    }

    /**
     * Test valid ipv6 adress.
     */
    public function testCheckActionPostIP6Happy()
    {
        global $di;

        // Setup di
        $di = new DIFactoryConfig();
        $di->loadServices(ANAX_INSTALL_PATH . "/config/di");

        // Use a different cache dir for unit test
        $di->get("cache")->setPath(ANAX_INSTALL_PATH . "/test/cache");

        // View helpers uses the global $di so it needs its value
        // $di = $this->di;

        // Setup the controller
        $controller = new ValidateIPController();
        $controller->setDI($this->di);
        $controller->initialize();
        $session = $di->get("session");

        // Setup post request
        $_POST["ip"] = "2607:f0d0:1002:51::4";

        // Get response
        $controller->checkActionPost();
        $res = $session->get("res");
        $exp = "2607:f0d0:1002:51::4 is a valid IPV6 address";

        $this->assertContains($exp, $res[1]);
    }

    /**
     * Test invalid ip adress.
     */
    public function testCheckActionPostSad()
    {
        global $di;

        // Setup di
        $di = new DIFactoryConfig();
        $di->loadServices(ANAX_INSTALL_PATH . "/config/di");

        // Use a different cache dir for unit test
        $di->get("cache")->setPath(ANAX_INSTALL_PATH . "/test/cache");

        // View helpers uses the global $di so it needs its value
        // $di = $this->di;

        // Setup the controller
        $controller = new ValidateIPController();
        $controller->setDI($this->di);
        $controller->initialize();
        $session = $di->get("session");

        // Setup post request
        $_POST["ip"] = "1.2.3.4.5";

        // Get response
        $controller->checkActionPost();
        $res = $session->get("res");
        $exp = "1.2.3.4.5 is not a valid IP address";

        $this->assertContains($exp, $res[1]);
    }

    /**
     * Test if session response have been reset.
     */
    public function testResetActionPost()
    {
        global $di;

        // Setup di
        $di = new DIFactoryConfig();
        $di->loadServices(ANAX_INSTALL_PATH . "/config/di");

        // Use a different cache dir for unit test
        $di->get("cache")->setPath(ANAX_INSTALL_PATH . "/test/cache");

        // View helpers uses the global $di so it needs its value
        // $di = $this->di;

        // Setup the controller
        $controller = new ValidateIPController();
        $controller->setDI($this->di);
        $controller->initialize();
        $session = $di->get("session");

        // Get response
        $controller->resetActionPost();
        $res = $session->get("res");
        $exp = "";

        $this->assertContains($exp, $res[1]);
    }
}
