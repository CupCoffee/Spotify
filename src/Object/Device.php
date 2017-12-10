<?php
/**
 * Created by PhpStorm.
 * User: leroy
 * Date: 10/22/2017
 * Time: 12:51 PM
 */

namespace Lorey\Spotify\Object;


class Device
{
    /**
     * @var string
     */
    public $id;

    /**
     * @var bool
     */
    public $is_active;

    /**
     * @var bool
     */
    public $is_restricted;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $type;

    /**
     * @var int
     */
    public $volume_percent;
}