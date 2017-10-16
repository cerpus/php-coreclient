<?php

return [
    "core" => [
        "url" => env("CERPUS_CORE_SERVER"),
        "key" => env("CERPUS_CORE_KEY"),
        "secret" => env("CERPUS_CORE_SECRET"),
        "token" => env("CERPUS_CORE_TOKEN"),
        "token_secret" => env("CERPUS_CORE_TOKEN_SECRET"),
    ],

    "auth" => [
        "url" => env("CERPUS_AUTH_SERVER"),
        "user" => env("CERPUS_AUTH_USER"),
        "secret" => env("CERPUS_AUTH_SECRET"),
    ],

    "adapter" => [
        'current' => env("CORE_CLIENT_ADAPTER", \Cerpus\CoreClient\Adapters\CoreAdapter::class),
        'client' => env("CORE_CLIENT_SERVICE", \Cerpus\CoreClient\Clients\Client::class),
    ]
];