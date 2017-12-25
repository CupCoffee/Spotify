<?php

namespace Lorey\Spotify\Endpoints;

use Lorey\Spotify\Http\Endpoint;
use Lorey\Spotify\Object\Album;
use Lorey\Spotify\Object\Album\BulkResponse;
use Lorey\Spotify\Object\Track\PagingObject;

trait Albums {
	public function getAlbum(string $id): Album
	{
		return $this->client->get(new Endpoint('/albums/{id}', Album::class), compact('id'));
	}

    /**
     * @param array $ids
     * @return Album[]
     */
	public function getAlbums(array $ids): array
	{
		return $this->client->get(new Endpoint('/albums', BulkResponse::class), compact('ids'))->albums;
	}

	public function getAlbumTracks(string $id): PagingObject
	{
		return $this->client->get(new Endpoint('/albums/{id}/tracks', PagingObject::class), compact('id'));
	}
}