<?php

use Anax\Route\Exception\ForbiddenException;
use Anax\Route\Exception\InternalErrorException;
use Anax\Route\Exception\NotFoundException;

/**
 * These routes are for demonstration purpose, to show how routes and
 * handlers can be created.
 */
return [
    // Path where to mount the routes, is added to each route path.
    // "mount" => "validate",

    // All routes in order
    "routes" => [
        [
            "info" => "Just say hi with a string.",
            "mount" => "validate",
            "handler" => "\Hab\MeModule\ValidateIPController"
        ],
    ]
];
