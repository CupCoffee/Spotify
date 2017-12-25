<?php
/**
 * Created by PhpStorm.
 * User: leroy
 * Date: 12/18/2017
 * Time: 7:39 PM
 */

namespace Lorey\Spotify\Tests;


use Dotenv\Dotenv;

trait Boot
{
    public static function loadEnv()
    {
        (new Dotenv(realpath(__DIR__ . DIRECTORY_SEPARATOR . '..')))->load();
    }
}