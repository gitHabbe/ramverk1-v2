<?php

namespace Hab\Book;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Test the SampleController.
 */
class BookControllerTest extends TestCase
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
        $this->controller = new BookController();
        $this->controller->setDI($this->di);
    }

    /**
     * Test the route "book".
     */
    public function testIndexAction()
    {
        $res = $this->controller->indexActionGet();
        $res = $res->getBody();
        $exp = "View all books";
        $this->assertContains($exp, $res);
    }

    /**
     * Test the route "book/create".
     */
    public function testCreateAction()
    {
        $res = $this->controller->createAction();
        $res = $res->getBody();
        $exp = "Create a item";
        $this->assertContains($exp, $res);
    }

    /**
     * Test the route "book/delete".
     */
    public function testDeleteAction()
    {
        $res = $this->controller->deleteAction();
        $res = $res->getBody();
        $exp = "Delete a Book";
        $this->assertContains($exp, $res);
    }

    /**
     * Test the route "book/update".
     */
    public function testUpdateAction()
    {
        $res = $this->controller->updateAction(1);
        $res = $res->getBody();
        $exp = "Update an item";
        $this->assertContains($exp, $res);
    }
}