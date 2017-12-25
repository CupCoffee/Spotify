<?php

namespace Lorey\Spotify\Http;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Uri;
use League\OAuth2\Client\Token\AccessToken;
use Lorey\Spotify\Http\Auth\OAuthProvider;

use function GuzzleHttp\uri_template;
use Lorey\Spotify\Spotify;
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
            $response = $this->httpClient->send($request);

            return $response;
        } catch (RequestException $exception) {
            echo $exception->getResponse()->getBody()->getContents();
            echo $exception->getMessage();
        }
    }

    public function get(Endpoint $endpoint, array $parameters = [])
    {
        $uri = $this->buildUri($endpoint, $parameters);

        $request = $this->oAuthProvider->getAuthenticatedRequest('GET', $uri, $this->accessToken, ['body' => json_encode($parameters)]);
        $response = $this->send($request);
        $json = $response->getBody()->getContents();
        $mappedResponse = Reify::map(new JsonMapper(), $json)->to($endpoint->getResponseType());
        return $mappedResponse;
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
        $uri = new Uri($this->httpClient->getConfig('base_uri'));
        $uri = $uri->withPath(Spotify::API_VERSION);

        if ($parameters) {
            $requestParameters = $parameters;

            $namedParameters = $this->getNamedParametersFromUri($endpoint->getPath());

            $queryParameters = array_diff_key($requestParameters, array_flip($namedParameters));
            $queryParameters = array_map(function($value) {
                if (is_array($value)) {
                    return implode(",", $value);
                }

                return $value;
            }, $queryParameters);

            $uri = $uri->withPath($this->buildPath($this->compileParameters($endpoint->getPath(), $parameters)));
            $uri = $uri->withQuery(http_build_query($queryParameters));
        } else {
            $uri = $uri->withPath($this->buildPath($endpoint->getPath()));
        }

        return $uri;
    }

    private function buildPath($path)
    {
        return Spotify::API_VERSION . '/' . ltrim($path, '/');
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