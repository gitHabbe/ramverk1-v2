<?php

namespace Anax\Controller;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Test the SampleJsonController.
 */
class LocationJsonControllerTest extends TestCase
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
        $this->controller = new LocationJsonController();
        $this->controller->setDI($this->di);
        $this->controller->initialize();
    }



    /**
     * Test if invalid city gives correct res
     */
    public function testIndexActionInvalidCity()
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
        $controller = new LocationJsonController();
        $controller->setDI($this->di);
        $controller->initialize();

        // Setup request
        $request = $this->di->get("request");
        $request->setGet("loc", "");

        // Get response
        $res = $controller->indexActionGet();
        // var_dump($res[0][0][1][1]);
        $exp = "Term:  didnt give a result";

        $this->assertIsArray($res);
        $this->assertEquals($res[0][0][1][1], $exp);
    }


    /**
     * Test if valid city gives correct res
     */
    public function testIndexActionValidCity()
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
        $controller = new LocationJsonController();
        $controller->setDI($this->di);
        $controller->initialize();

        // Setup request
        $request = $this->di->get("request");
        $request->setGet("loc", "karlskrona");

        // Get response
        $res = $controller->indexActionGet();
        // var_dump($res[0][0][1][1]);
        $exp = "Term:  didnt give a result";

        $this->assertIsArray($res);
        $this->assertIsfloat($res[0][0][0]->latitude);
    }


    /**
     * Test if IP is valid
     */
    public function testIndexActionValidIP()
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
        $controller = new LocationJsonController();
        $controller->setDI($this->di);
        $controller->initialize();

        // Setup request
        $request = $this->di->get("request");
        $request->setGet("loc", "45.144.116.1");

        // Get response
        $res = $controller->indexActionGet();

        $this->assertIsArray($res);
        $this->assertIsfloat($res[0][0][0]->latitude);
    }


    /**
     * Test if IP is invalid
     */
    public function testIndexActionInvalidIP()
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
        $controller = new LocationJsonController();
        $controller->setDI($this->di);
        $controller->initialize();

        // Setup request
        $request = $this->di->get("request");
        $request->setGet("loc", "192.168.1.1");

        // Get response
        $res = $controller->indexActionGet();
        $exp = "IP: 192.168.1.1 did not provide a location";

        $this->assertIsArray($res);
        $this->assertEquals($res[0][0][1][1], $exp);
    }
}
