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
class LocationJsonController implements ContainerInjectableInterface
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
        $request    = $this->di->get("request");
        $fetch      = $this->di->get("fetch");
        $validator  = $this->di->get("ip");

        $locations  = explode(",", $request->getGet("loc", ""));

        $keys       = require(ANAX_INSTALL_PATH . "/config.php");
        $darkKey    = $keys["darkSky"];
        $boxKey     = $keys["mapbox"];
        $ipKey      = $keys["key"];

        $temp = [];
        foreach ($locations as $loc) {
            $validator->setIP(ltrim($loc));
            array_push($temp, $validator->sendRes());
        }

        $ress = [];
        foreach ($temp as $tmp) {
            $error = "";
            if ($tmp["isValid"]) {
                $ip = $tmp["ip"];
                $res = json_decode($fetch->fetch("GET", "http://api.ipstack.com/$ip?access_key=$ipKey"));
                if (!$res->city) { 
                    $error = "IP: $ip did not provide a location";
                } else {
                    $res = [$res->latitude, $res->longitude];
                }
            } else {
                $ip = $tmp["ip"];
                $res = json_decode($fetch->fetch("GET", "https://api.mapbox.com/geocoding/v5/mapbox.places/$ip.json?access_token=$boxKey"));
                // var_dump(strlen($res->message));
                // die();
                if (property_exists($res, "message") || count($res->features) === 0) { 
                    $error = "Term: $ip didnt give a result";
                } else {
                    $res = [$res->features[0]->geometry->coordinates[1], $res->features[0]->geometry->coordinates[0]];
                }
            }
            array_push($ress, [$res, $error, $tmp["ip"]]);
        }
        $data = [];
        foreach ($ress as $locc) {
            if ($locc[1] == "") {
                $lat = $locc[0][0];
                $lng = $locc[0][1];
                $res = json_decode($fetch->fetch("GET", "https://api.darksky.net/forecast/$darkKey/$lat,$lng"));
                array_push($data, [$res, $locc]);
            } else {
                // var_dump($locc);
                array_push($data, [null, $locc]);
            }
        }

        return [ $data ];
    }
}
