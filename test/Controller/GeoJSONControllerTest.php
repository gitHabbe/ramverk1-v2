<?php

namespace Anax\Controller;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Test the SampleJsonController.
 */
class GeoJSONControllerTest extends TestCase
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
        $this->controller = new GeoJSONController();
        $this->controller->setDI($this->di);
        $this->controller->initialize();
    }



    /**
     * Test if API returns happy ipv4 response.
     */
    public function testSearchActionPostIP4Happy()
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
        $controller = new GeoJSONController();
        $controller->setDI($this->di);
        $controller->initialize();

        // Setup request
        $request = $this->di->get("request");
        $request->setPost("ip", "1.2.3.4");

        // Get response
        $res = $controller->searchActionPost();
        $res = json_decode($res[0]);
        $exp = "1.2.3.4";

        // $this->assertIsArray($res);
        $this->assertEquals($res->ip, $exp);
    }

    /**
     * Test if API returns happy ipv6 response.
     */
    public function testSearchActionGet()
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
        $controller = new GeoJSONController();
        $controller->setDI($this->di);
        $controller->initialize();

        // Setup request
        $request = $this->di->get("request");
        $request->setGet("ip", "2607:f0d0:1002:51::4");

        // Get response
        $res = $controller->searchActionGet();
        $res = json_decode($res[0]);
        $exp = "2607:f0d0:1002:51::4";

        // $this->assertIsArray($res);
        $this->assertEquals($res->ip, $exp);
    }
}
