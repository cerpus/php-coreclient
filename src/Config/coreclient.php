<?php

return [
    /*
     * URL to the groups API
     */
    "core" => [
        "url" => env("CERPUS_CORE_SERVER"),
        "key" => env("CERPUS_CORE_KEY"),
        "secret" => env("CERPUS_CORE_SECRET")
    ],

    "auth" => [
        "url" => env("CERPUS_AUTH_SERVER"),
        "user" => env("CERPUS_AUTH_USER"),
        "secret" => env("CERPUS_AUTH_SECRET"),
    ],

    "adapter" => [
        'current' => env("CORE_CLIENT_ADAPTER", \Cerpus\CoreClient\Adapters\CoreAdapter::class),
        'service' => env("CORE_CLIENT_SERVICE"),
    ]
    /*
     * Default class for groups
     */
    //"adapter" => env("GROUPS_ADAPTER", \Cerpus\GroupClient\Adapters\GroupsApi::class),
];