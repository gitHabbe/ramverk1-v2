<?php
/**
 * Configuration file for DI container.
 */
return [
    "services" => [
        "ip" => [
            "shared" => true,
            "callback" => function () {
                return new \Hab\MeModule\ValidateIP();
            },
        ],
    ],
];