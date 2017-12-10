<?php

namespace Lorey\Spotify\Object;


class Response
{
	/**
	 * @var Album[]
	 */
	public $albums;

	/**
	 * @var Artist[]
	 */
	public $artists;

	/**
	 * @var Playlist[]
	 */
	public $playlists;

	/**
	 * @var Track[]
	 */
	public $tracks;

	/**
	 * @var Error
	 */
	public $error;

	public function hasError()
	{
		return isset($this->error);
	}
}