<?php

namespace Lorey\Spotify\Object\Track;

use \Lorey\Spotify\Object\PagingObject as BasePagingObject;

class PagingObject extends BasePagingObject
{

	/**
	 * @var \Lorey\Spotify\Object\Track[]
	 */
	public $items;
}