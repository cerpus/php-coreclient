<?php

namespace Cerpus\CoreClient\Clients;


use Cerpus\CoreClient\Contracts\CoreClientContract;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\RequestOptions;
use kamermans\OAuth2\GrantType\ClientCredentials;
use kamermans\OAuth2\OAuth2Middleware;

class Oauth2Client implements CoreClientContract
{
    public static function getClient($config): ClientInterface
    {
        $reauth_client = new Client([
            'base_uri' => config('auth.cerpus_auth.server') . "/oauth/token",
        ]);
        $reauth_config = [
            "client_id" => config('auth.cerpus_auth.user'),
            "client_secret" => config('auth.cerpus_auth.secret'),
        ];
        $grant_type = new ClientCredentials($reauth_client, $reauth_config);
        $oauth = new OAuth2Middleware($grant_type);

        $stack = HandlerStack::create();
        $stack->push($oauth);

        $client = new Client([
            'base_uri' => config('services.contentAuthor.url'),
            'handler' => $stack,
            RequestOptions::AUTH => 'oauth',
        ]);
        return $client;
    }
}