<?php

namespace Lorey\Spotify\Object\Artist;

use \Lorey\Spotify\Object\PagingObject as BasePagingObject;

class PagingObject extends BasePagingObject
{

	/**
	 * @var \Lorey\Spotify\Object\Artist[]
	 */
	public $items;
}