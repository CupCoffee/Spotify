<?php

namespace Lorey\Spotify\Object\Album;

use Lorey\Spotify\Object\Album;
use \Lorey\Spotify\Object\PagingObject as BasePagingObject;

class PagingObject extends BasePagingObject
{

	/**
	 * @var \Lorey\Spotify\Object\Album[]
	 */
	public $items;
}