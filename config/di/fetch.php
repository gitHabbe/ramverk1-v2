<?php
/**
 * Configuration file for DI container.
 */

return [
    "services" => [
        "fetch" => [
            "shared" => true,
            "callback" => function () {
                return new \Hab\MeModule\Fetch2();
            },
        ],
    ],
];
