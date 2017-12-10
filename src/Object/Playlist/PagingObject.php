<?php

namespace Lorey\Spotify\Object\Playlist;

use \Lorey\Spotify\Object\PagingObject as BasePagingObject;

class PagingObject extends BasePagingObject
{

	/**
	 * @var \Lorey\Spotify\Object\Playlist[]
	 */
	public $items;
}