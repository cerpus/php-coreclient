# Core Client

This is a client that handles requests to Core.

## Installation in Laravel

1. Install the code with composer: `composer require cerpus/coreclient`
1. Add the class CoreClientServiceProvider in the list of providers for your site
    1. Normally located in config/app.php in Laravel
    1. Add the code `$app->register(\Cerpus\CoreClient\CoreClientServiceProvider::class);` in bootstrap/app.php in Lumen 
1. Setup url to Core and Auth. The package is delivered with default settings that's read from the env file
    1. Core
        * CERPUS_CORE_SERVER
        * CERPUS_CORE_KEY
        * CERPUS_CORE_SECRET
        * CERPUS_CORE_TOKEN
        * CERPUS_CORE_TOKEN_SECRET
        
    1. Auth
        * CERPUS_AUTH_SERVER
        * CERPUS_AUTH_USER
        * CERPUS_AUTH_SECRET
    1. Adapter
        * CORE_CLIENT_ADAPTER, _default set to CoreAdapter_
        * CORE_CLIENT_SERVICE, _default set to Client(no authentication)_
 1. To use the client create a new object of type CoreContract or call static facade CoreClient