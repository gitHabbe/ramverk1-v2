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
class LocationController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    /**
     * @return page
     */
    public function indexAction()
    {
        $page       = $this->di->get("page");
        $session    = $this->di->get("session");
        $data = [
            "coords" => $session->get("coords"),
            // "ress" => $session->get("ress"),
        ];
        $page->add("location", $data);

        return $page->render(["title" => "Location"]);
    }

    public function indexActionPost()
    {
        $session    = $this->di->get("session");
        $request    = $this->di->get("request");
        $response   = $this->di->get("response");
        $location   = $this->di->get("location");
        $validator  = $this->di->get("ip");
        $fetch      = $this->di->get("fetch");

        $keys       = require(ANAX_INSTALL_PATH . "/config.php");
        $darkKey    = $keys["darkSky"];
        $boxKey     = $keys["mapbox"];
        $ipKey      = $keys["key"];

        $locations = explode(",", $request->getPost("location"));
        // $resArray = $validator->multiValidate($locations);
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
                if (count($res->features) == 0) { 
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
                var_dump($locc);
                array_push($data, [null, $locc]);
            }
        }
        $session->set("coords", $data);
        
        return $response->redirect("location");
    }

}
