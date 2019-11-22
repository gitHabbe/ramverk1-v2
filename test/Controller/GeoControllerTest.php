<?php

namespace Anax\Controller;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Test the SampleJsonController.
 */
class GeoControllerTest extends TestCase
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
        $controller = new GeoController();
        $controller->setDI($this->di);
        $controller->initialize();

        // Get response
        $res = $controller->indexActionGet();
        $exp = "Validate IP | ramverk1";
        // $exp = "API can be found";
        $body = $res->getBody();
        // var_dump($body);

        $this->assertContains($exp, $body);
    }

    /**
     * Test validate ipv4 adress.
     */
    public function testCheckActionPostGeoHappy()
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
        $controller = new GeoController();
        $controller->setDI($this->di);
        $controller->initialize();
        $session = $di->get("session");

        // Setup post request
        // Can't properly set POST variable for som reason. Is this intentional?
        // Also don't know why I have to reference $di with $this keyword.
        // $this->di->get("request")->setPost("ip", "1.2.3.4");
        $this->di->get("request")->setGlobals(["post" => ["ip" => "1.2.3.4"]]);

        // Get response
        $controller->searchActionPost();
        $res = $session->get("res");
        $exp = "ipv4";

        $this->assertContains($exp, $res["fetch"]->type);
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
        $controller = new GeoController();
        $controller->setDI($this->di);
        $controller->initialize();
        $session = $di->get("session");

        // Get response
        $controller->resetActionPost();
        $res = $session->get("res");
        $exp = [];

        $this->assertEquals($exp, $res);
    }
}
