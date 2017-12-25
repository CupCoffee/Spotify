<?php

namespace Lorey\Spotify\Tests;

use League\OAuth2\Client\Grant\ClientCredentials;
use Lorey\Spotify\Http\Auth\OAuthProvider;
use Lorey\Spotify\Http\Client;
use Lorey\Spotify\Spotify;

trait Authorize
{
    public static function authorize(): Spotify
    {

        $provider = new OAuthProvider([
            'clientId' => getenv('CLIENT_ID'),
            'clientSecret' => getenv('CLIENT_SECRET'),
        ]);

        $token = $provider->getAccessToken(new ClientCredentials());

        return new Spotify(new Client(new \GuzzleHttp\Client(['base_uri' => 'https://api.spotify.com']), $provider, $token));
    }
}