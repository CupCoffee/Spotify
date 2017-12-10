<?php

namespace Lorey\Spotify\Api\Http;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Uri;
use League\OAuth2\Client\Token\AccessToken;
use Lorey\Spotify\Http\Auth\OAuthProvider;

use function GuzzleHttp\uri_template;
use Psr\Http\Message\RequestInterface;
use Reify\Data\JsonMapper;
use Reify\Reify;

class Client
{
    private $httpClient;
    /**
     * @var OAuthProvider
     */
    private $oAuthProvider;
    /**
     * @var AccessToken
     */
    private $accessToken;

    public function __construct(HttpClient $httpClient, OAuthProvider $oAuthProvider, AccessToken $accessToken)
    {
        $this->httpClient = $httpClient;
        $this->oAuthProvider = $oAuthProvider;
        $this->accessToken = $accessToken;
    }

    private function send(RequestInterface $request)
    {
        try {
            return $this->httpClient->send($request);
        } catch (RequestException $exception) {
            dump($exception->getResponse()->getBody()->getContents());
            dump($exception->getMessage());
        }
    }

    public function get(Endpoint $endpoint, array $parameters = [])
    {
        $uri = $this->buildUri($endpoint, $parameters);

        $request = $this->oAuthProvider->getAuthenticatedRequest('GET', $uri, $this->accessToken, ['body' => json_encode($parameters)]);
        return Reify::map(new JsonMapper(), $this->send($request)->getBody()->getContents())->to($endpoint->getResponseType());
    }

    public function post(Endpoint $endpoint, array $parameters = [])
    {
        $uri = $this->buildUri($endpoint, $parameters);

        $request = $this->oAuthProvider->getAuthenticatedRequest('POST', $uri, $this->accessToken, ['body' => json_encode($parameters)]);
        return $this->send($request);
    }

    public function put(Endpoint $endpoint, array $parameters= [])
    {
        $uri = $this->buildUri($endpoint, $parameters);

        $request = $this->oAuthProvider->getAuthenticatedRequest('PUT', $uri, $this->accessToken, ['body' => json_encode($parameters)]);
        return $this->send($request);
    }

    private function buildUri(Endpoint $endpoint, array $parameters = null): Uri
    {
        $uri = new Uri(config('spotify.api.base_uri'));
        $uri = $uri->withPath(config('spotify.api.version'));

        if ($parameters) {
            $requestParameters = collect($parameters);

            $namedParameters = $this->getNamedParametersFromUri($endpoint->getPath());
            $queryParameters = $requestParameters->except($namedParameters)->keys()->toArray();

            $uri = $uri->withPath($this->buildPath($this->compileParameters($endpoint->getPath(), $parameters)));
            $uri = $uri->withQuery(http_build_query($requestParameters->only($queryParameters)->toArray()));
        } else {
            $uri = $uri->withPath($this->buildPath($endpoint->getPath()));
        }

        return $uri;
    }

    private function buildPath($path)
    {
        return config('spotify.api.version') . '/' . ltrim($path, '/');
    }

    private function getNamedParametersFromUri(string $uri): array
    {
        preg_match_all('/\{(.*?)\}/', $uri, $matches);

        if (!empty($matches) && isset($matches[1])) {
            return $matches[1];
        }

        return [];
    }

    private function compileParameters(string $uri, array $parameters): string
    {
        return uri_template($uri, $parameters);
    }
}