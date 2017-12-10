<?php

namespace Lorey\Spotify\Object;

class CurrentlyPlayingContext
{
    /**
     * @var Device
     */
    public $device;

    /**
     * @var string
     */
    public $repeat_state;

    /**
     * @var bool
     */
    public $shuffle_state;

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