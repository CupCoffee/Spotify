<?php

namespace Lorey\Spotify\Object;


use League\OAuth2\Client\Provider\ResourceOwnerInterface;

class User implements ResourceOwnerInterface
{
	/**
	 * @var string
	 */
	public $display_name;

	/**
	 * @var ExternalUrl
	 */
	public $external_urls;

	/**
	 * @var Followers
	 */
	public $followers;

	/**
	 * @var string
	 */
	public $href;

	/**
	 * @var string
	 */
	public $id;

	/**
	 * @var Image[]
	 */
	public $images;

	/**
	 * @var string
	 */
	public $type;

	/**
	 * @var string
	 */
	public $uri;

    /**
     * Returns the identifier of the authorized resource owner.
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Return all of the owner details available as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return (array) $this;
    }
}