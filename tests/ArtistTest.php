<?php

namespace Lorey\Spotify\Tests;

use Lorey\Spotify\Object\Album\PagingObject;
use Lorey\Spotify\Object\Artist;
use Lorey\Spotify\Object\Track;

class ArtistTest extends Test
{
    /**
     * @var artist
     */
    private static $artist;

    /**
     * @var array
     */
    private static $artists;

    /**
     * @var PagingObject
     */
    private static $artistAlbums;

    /**
     * @var Track[]
     */
    private static $artistTopTracks;

    /**
     * @var Artist[]
     */
    private static $artistRelatedArtists;

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();

        $artistId = getenv('TEST_ARTIST_ID');
        $country = getenv('TEST_COUNTRY');

        self::$artist = self::$spotify->getArtist($artistId);
        self::$artists = self::$spotify->getArtists([$artistId]);
        self::$artistAlbums = self::$spotify->getArtistAlbums($artistId);
        self::$artistTopTracks = self::$spotify->getArtistTopTracks($artistId, $country);
        self::$artistRelatedArtists = self::$spotify->getArtistRelatedArtists($artistId);
    }

    public function test_get_artist()
    {
        $this->assertInstanceOf(Artist::class, self::$artist);
    }

    public function test_get_artists()
    {
        $this->assertInternalType('array',self::$artists);
        $this->assertNotEmpty(self::$artists);

        foreach(self::$artists as $artist) {
            $this->assertInstanceOf(Artist::class, $artist);
        }
    }

    public function test_get_artist_albums()
    {
        $this->assertInstanceOf(PagingObject::class, self::$artistAlbums);

        $this->assertInternalType('array', self::$artistAlbums->items);
    }

    public function test_get_artist_top_tracks()
    {
        $this->assertInternalType('array', self::$artistTopTracks);

        foreach(self::$artistTopTracks as $track) {
            $this->assertInstanceOf(Track::class, $track);
        }
    }

    public function test_get_artist_related_artists()
    {
        $this->assertInternalType('array', self::$artistRelatedArtists);
        $this->assertNotEmpty(self::$artistRelatedArtists);

        foreach(self::$artistRelatedArtists as $artist) {
            $this->assertInstanceOf(Artist::class, $artist);
        }
    }
}