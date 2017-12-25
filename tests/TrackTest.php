<?php
/**
 * Created by PhpStorm.
 * User: leroy
 * Date: 12/18/2017
 * Time: 10:37 PM
 */

namespace Lorey\Spotify\Tests;


use Lorey\Spotify\Object\Album;
use Lorey\Spotify\Object\Artist;
use Lorey\Spotify\Object\Track;

class TrackTest extends Test
{
    /**
     * @var Track
     */
    private static $track;

    /**
     * @var Track[]
     */
    private static $tracks;

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();

        self::$track = self::$spotify->getTrack(getenv('TEST_TRACK_ID'));
        self::$tracks = self::$spotify->getTracks([getenv('TEST_TRACK_ID')]);

    }

    public function test_get_track()
    {
        $this->assertInstanceOf(Track::class, self::$track);
    }

    public function test_get_tracks()
    {
        $this->assertInternalType('array', self::$tracks);
        $this->assertNotEmpty(self::$tracks);

        foreach(self::$tracks as $track) {
            $this->assertInstanceOf(Track::class, $track);
        }
    }

    public function test_track_contains_album()
    {
        $this->assertAttributeInstanceOf(Album::class, 'album', self::$track);
    }

    public function test_track_contains_artists()
    {
        $this->assertAttributeInternalType('array', 'artists', self::$track);

        foreach(self::$track->artists as $artist) {
            $this->assertInstanceOf(Artist::class, $artist);
        }
    }
}