<?php
/**
 * Configuration file for DI container.
 */
return [
    "services" => [
        "location" => [
            "shared" => true,
            "callback" => function () {
                $location = new \Hab\Model\Location();
                return $location;
            },
        ],
    ],
];
