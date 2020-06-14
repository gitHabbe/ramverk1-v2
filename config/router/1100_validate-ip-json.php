<?php

use Anax\Route\Exception\ForbiddenException;
use Anax\Route\Exception\InternalErrorException;
use Anax\Route\Exception\NotFoundException;

return [
    // Path where to mount the routes, is added to each route path.
    "mount" => "api",

    // All routes in order
    "routes" => [
        [
            "info" => "Just say hi with a string.",
            "mount" => "ip",
            "handler" => "\Anax\Controller\ValidateIPJsonController"
        ],
        [
            "info" => "Just say hi with a string.",
            "mount" => "geo",
            "handler" => "\Anax\Controller\GeoJSONController"
        ],
        [
            "info" => "Just say hi with a string.",
            "mount" => "location",
            "handler" => "\Anax\Controller\LocationJSONController"
        ],
    ]
];
