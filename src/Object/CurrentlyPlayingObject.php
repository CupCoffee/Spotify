<?php
/**
 * Created by PhpStorm.
 * User: leroy
 * Date: 10/22/2017
 * Time: 12:55 PM
 */

namespace Lorey\Spotify\Object;


class CurrentlyPlayingObject
{
    /**
     * @var Context
     */
    public $context;

    /**
     * @var int
     */
    public $timestamp;

    /**
     * @var int
     */
    public $progress_ms;

    /**
     * @var bool
     */
    public $is_playing;

    /**
     * @var Track
     */
    public $item;
}