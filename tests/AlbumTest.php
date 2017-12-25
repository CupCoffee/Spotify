<?php
/**
 * Created by PhpStorm.
 * User: leroy
 * Date: 12/20/2017
 * Time: 8:18 PM
 */

namespace Lorey\Spotify\Tests;

use Lorey\Spotify\Object\Album;
use Lorey\Spotify\Object\Artist;
use Lorey\Spotify\Object\PagedResponse;
use Lorey\Spotify\Object\Track;

class AlbumTest extends Test
{
    /**
     * @var Album
     */
    protected static $album;

    /**
     * @var array
     */
    protected static $albums;

    /**
     * @var PagedResponse
     */
    protected static $albumTracks;

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();

        $albumId = getenv('TEST_ALBUM_ID');

        self::$album = self::$spotify->getAlbum($albumId);
        self::$albums = self::$spotify->getAlbums([$albumId]);
        self::$albumTracks = self::$spotify->getAlbumTracks($albumId);
    }

    public function test_get_album()
    {
        $this->assertInstanceOf(Album::class, self::$album);
    }

    public function test_get_albums()
    {
        $this->assertInternalType('array', self::$albums);

        foreach(self::$albums as $album) {
            $this->assertInstanceOf(Album::class, $album);
        }
    }

    public function test_get_album_tracks()
    {
        $this->assertInstanceOf(Track\PagingObject::class, self::$albumTracks);

        $this->assertInternalType('array', self::$albumTracks->items);
    }

    public function test_album_contains_tracks()
    {
        $this->assertAttributeInternalType('array', 'tracks', self::$album);

        foreach(self::$album->tracks as $track) {
            $this->assertInstanceOf(Track::class, $track);
        }
    }

    public function test_album_contains_artists()
    {
        $this->assertAttributeInternalType('array', 'artists', self::$album);

        foreach(self::$album->artists as $track) {
            $this->assertInstanceOf(Artist::class, $track);
        }
    }
}