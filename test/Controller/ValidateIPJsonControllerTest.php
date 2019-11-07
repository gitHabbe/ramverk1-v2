<?php

namespace Anax\Controller;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Test the SampleJsonController.
 */
class ValidateIPJsonControllerTest extends TestCase
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
     * Test if API returns happy ipv4 response.
     */
    public function testIndexActionIP4Happy()
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
        $controller = new ValidateIPJsonController();
        $controller->setDI($this->di);
        $controller->initialize();

        // Setup request
        $request = $this->di->get("request");
        $request->setGet("ip", "1.2.3.4");

        // Get response
        $res = $controller->indexActionGet();
        $exp = "1.2.3.4";

        $this->assertIsArray($res);
        $this->assertEquals($res[0]["ip"], $exp);
    }

    /**
     * Test if API returns happy ipv6 response.
     */
    public function testIndexActionIP6Happy()
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
        $controller = new ValidateIPJsonController();
        $controller->setDI($this->di);
        $controller->initialize();

        // Setup request
        $request = $this->di->get("request");
        $request->setGet("ip", "2607:f0d0:1002:51::4");

        // Get response
        $res = $controller->indexActionGet();
        $exp = "2607:f0d0:1002:51::4";

        $this->assertIsArray($res);
        $this->assertEquals($res[0]["ip"], $exp);
    }

    /**
     * Test if error msgs send correct info.
     */
    public function testIndexActionSad()
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
        $controller = new ValidateIPJsonController();
        $controller->setDI($this->di);
        $controller->initialize();

        // Setup request
        $request = $this->di->get("request");
        $request->setGet("ip", "bad.ip.by.user");
        
        // Get response
        $res = $controller->indexActionGet();
        $exp = "invalid ip";
        $this->assertIsArray($res);
        $this->assertEquals($res[0]["ip"], $exp);
        
        $request->setGet("ip", "");
        $res = $controller->indexActionGet();
        $exp = "no ip specified, use ip query to input an ip";
        $this->assertIsArray($res);
        $this->assertEquals($res[0]["ip"], $exp);
    }
}
