<?php

namespace Anax\Controller;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;
use Hab\Model;

/**
 * Test the SampleJsonController.
 */
class FetchModelTest extends TestCase
{
    public function testFetchMethod()
    {
        $fetch = new \Hab\Model\Fetch("POST", "1.2.3.4");
        $fetch->setMethod("GET");
        $res = $fetch->getMethod();
        // $fetch->applyMethod();
        $exp = "GET";
        $this->assertEquals($res, $exp);
    }

    public function testFetchApplyMethod()
    {
        $fetch = new \Hab\Model\Fetch("GET", "1.2.3.4");
        $fetch->applyMethod("GET");
        $fetch->applyMethod("POST");
        $fetch->applyMethod("PUT");
        $fetch->applyMethod("DELETE");
        $fetch->applyMethod("WRONG");
        $res = $fetch->getMethod();
        $exp = "DELETE";
        $this->assertEquals($res, $exp);
    }

    public function testFetchApplyParamsMethod()
    {
        $fetch = new \Hab\Model\Fetch("POST", "1.2.3.4");
        $params = [
            "ip" => "1.2.3.4",
        ];
        $fetch->applyParams($params);
        $fetch->applyMethod("PUT");
        $fetch->applyParams($params);
        $fetch->applyMethod("DELETE");
        $fetch->applyParams($params);
        $fetch->applyMethod("WRONG");
        $fetch->applyParams($params);
        $res = $fetch->getMethod();
        $exp = "DELETE";
        $this->assertEquals($res, $exp);
    }
}
