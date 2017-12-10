<?php
/**
 * Created by PhpStorm.
 * User: leroy
 * Date: 10/22/2017
 * Time: 12:53 PM
 */

namespace Lorey\Spotify\Object;


class Context
{
    /**
     * @var string
     */
    public $uri;

    /**
     * @var string
     */
    public $href;

    /**
     * @var ExternalUrl
     */
    public $external_urls;

    /**
     * @var string
     */
    public $type;
}