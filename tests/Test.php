<?php
/**
 * Created by PhpStorm.
 * User: leroy
 * Date: 12/18/2017
 * Time: 10:36 PM
 */

namespace Lorey\Spotify\Tests;


use Lorey\Spotify\Spotify;
use PHPUnit\Framework\TestCase;

abstract class Test extends TestCase
{
    use Boot;
    use Authorize;

    /**
     * @var Spotify
     */
    protected static $spotify;

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();

        self::loadEnv();
        self::$spotify = self::authorize();
    }
}