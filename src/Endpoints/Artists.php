<?php

namespace Lorey\Spotify\Endpoints;

use Lorey\Spotify\Http\Endpoint;
use Lorey\Spotify\Object\Artist;
use Lorey\Spotify\Object\Album\PagingObject;
use Lorey\Spotify\Object\Artist\BulkResponse;

trait Artists
{
    public function getArtist(string $id): Artist
    {
        return $this->client->get(new Endpoint('/artists/{id}', Artist::class), compact('id'));
    }

    /**
     * @param array $ids
     * @return Artist[]
     */
    public function getArtists(array $ids): array
    {
        return $this->client->get(new Endpoint('/artists', BulkResponse::class), compact('ids'))->artists;
    }

    public function getArtistAlbums(string $id): PagingObject
    {
        return $this->client->get(new Endpoint('/artists/{id}/albums', PagingObject::class), compact('id'));
    }

    public function getArtistTopTracks(string $id, string $country)
    {
        return $this->client->get(new Endpoint('/artists/{id}/top-tracks', \Lorey\Spotify\Object\Track\BulkResponse::class), compact(['id', 'country']))->tracks;
    }

    public function getArtistRelatedArtists(string $id)
    {
        return $this->client->get(new Endpoint('/artists/{id}/related-artists', BulkResponse::class), compact('id'))->artists;
    }
}