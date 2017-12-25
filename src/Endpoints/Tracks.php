<?php

namespace Lorey\Spotify\Endpoints;

use Lorey\Spotify\Http\Endpoint;
use Lorey\Spotify\Object\Album;
use Lorey\Spotify\Object\Track;
use Lorey\Spotify\Object\PagedResponse;

trait Tracks {
	public function getTrack($id): Track
    {
        return $this->client->get(new Endpoint('/tracks/{id}', Track::class), compact('id'));
    }

    public function getTracks(array $ids): array
    {
        return $this->client->get(new Endpoint('/tracks', Track\BulkResponse::class), compact('ids'))->tracks;
    }
}