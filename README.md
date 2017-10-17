# Core Client

This is a client that handles requests to Core.

## Installation in Laravel

1. Make sure that the following repositories are in your composer.json 
    ```
    "repositories": [
            {
                "type": "composer",
                "url": "https://composer.cerpus.net/"
            },
            {
              "type" : "composer",
              "url" : "https://composer-3rdparty.cerpus.net/"
            }
        ]
    ```
1. Install the code with composer: `composer require cerpus/coreclient`
1. Add the class CoreClientServiceProvider in the list of providers for your site
    1. Normally located in config/app.php in Laravel
    1. Add the code `$app->register(\Cerpus\CoreClient\CoreClientServiceProvider::class);` in bootstrap/app.php in Lumen 
1. Setup url to Core and Auth, depending on level of security. The package is delivered with default settings that's read from the env file. If default key is not possible, fallback is listed in parethesis
    1. Core
        * CERPUS_CORE_SERVER (_CORECLIENT_CORE_SERVER_)
        * CERPUS_CORE_KEY (_CORECLIENT_CORE_KEY_)
        * CERPUS_CORE_SECRET (_CORECLIENT_CORE_SECRET_)
        * CERPUS_CORE_TOKEN (_CORECLIENT_CORE_TOKEN_)
        * CERPUS_CORE_TOKEN_SECRET (_CORECLIENT_CORE_TOKEN_SECRET_)
        
    1. Auth
        * CERPUS_AUTH_SERVER (_CORECLIENT_AUTH_SERVER_)
        * CERPUS_AUTH_USER (_CORECLIENT_AUTH_USER_)
        * CERPUS_AUTH_SECRET (_CORECLIENT_AUTH_SECRET_)
    1. Adapter
        * CORECLIENT_ADAPTER, _default set to CoreAdapter_
        * CORECLIENT_SERVICE, _default set to Client(no authentication)_
 1. To use the client create a new object of type CoreContract or call static facade CoreClient