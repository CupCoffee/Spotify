<?php

namespace Lorey\Spotify;


use Lorey\Spotify\Endpoints\Albums;
use Lorey\Spotify\Endpoints\Artists;
use Lorey\Spotify\Endpoints\Tracks;
use Lorey\Spotify\Http\Endpoint;
use Lorey\Spotify\Http\Client;
use Lorey\Spotify\Object\CurrentlyPlayingContext;
use Lorey\Spotify\Object\Device;
use Lorey\Spotify\Object\PagedResponse;


class Spotify
{
    const API_VERSION = 'v1';

    use Tracks;
    use Artists;
    use Albums;

    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
	}

    public function search($q, $type = 'album,artist,playlist,track'): PagedResponse
    {
        return $this->client->get(new Endpoint('/search', PagedResponse::class), compact('q', 'type'));
    }

    public function searchTrack($q): PagedResponse
    {
        return $this->search($q, 'track');
    }

    public function searchArtist($q): PagedResponse
    {
        return $this->search($q, 'artist');
    }

    public function transferPlayback(Device $device, bool $play = true): void
    {
        $device_ids = [$device->id];

        $this->client->put(new Endpoint('/me/player'), compact(['device_ids', 'play']));
    }

    public function play(string $context_uri = null)
    {
        if (strpos($context_uri, 'track') !== false) {
            $input = ['uris' => [$context_uri]];
        } else {
            $input = compact('context_uri');
        }

        $response = $this->client->put(new Endpoint('/me/player/play'), $input);

        return $response->getStatusCode() === 204;
    }

    public function pause()
    {
        $response = $this->client->put(new Endpoint('/me/player/pause'));

        return $response->getStatusCode() === 204;
    }

    public function getCurrentlyPlayingContext(): CurrentlyPlayingContext
    {
        return $this->client->get(new Endpoint('/me/player', CurrentlyPlayingContext::class));
    }
}