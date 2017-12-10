<?php

namespace Lorey\Spotify\Api\Http;

use GuzzleHttp\Psr7\Uri;

class Endpoint
{
    /**
     * @var string
     */
    private $path;

    /**
     * @var object
     */
    private $responseType;

    public function __construct(string $path, $responseType = null)
    {
        $this->path = $path;
        $this->responseType = $responseType;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    public function getResponseType()
    {
        return $this->responseType;
    }
}