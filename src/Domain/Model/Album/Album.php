<?php
/**
 * Copyright (c) 2018. Miguel Ángel Sánchez Fernández.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Domain\Model\Album;

use App\Domain\Model\Artist\Artist;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;

/**
 * Album
 */
class Album
{
    /**
     * @var AlbumId
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var \DateTime
     */
    private $publishing_date;

    /**
     * @var PersistentCollection
     */
    private $artists;

    /**
     * Album constructor.
     * @param AlbumId $id
     * @param string $title
     * @param \DateTime $publishing_date
     */
    public function __construct(AlbumId $id, string $title, \DateTime $publishing_date)
    {
        $this->id = $id;
        $this->title = $title;
        $this->publishing_date = $publishing_date;
        $this->artists = new ArrayCollection();
    }

    /**
     * @param string $title
     * @param \DateTime $publishing_date
     */
    public function update(string $title, \DateTime $publishing_date)
    {
        $this->title = $title;
        $this->publishing_date = $publishing_date;
    }

    /**
     * Get id.
     *
     * @return AlbumId
     */
    public function getId() : AlbumId
    {
        return $this->id;
    }

    /**
     * Get title.
     *
     * @return string
     */
    public function getTitle() : string
    {
        return $this->title;
    }

    /**
     * Get publishingDate.
     *
     * @return \DateTime
     */
    public function getPublishingDate() : \DateTime
    {
        return $this->publishing_date;
    }

    /**
     * @return PersistentCollection
     */
    public function getArtists(): PersistentCollection
    {
        return $this->artists;
    }

    /**
     * @param Artist $artist
     */
    public function addArtist(Artist $artist) : void
    {
        $artist->addAlbum($this); // synchronously updating inverse side
        $this->artists->add($artist);
    }

    /**
     * @param Artist $artist
     */
    public function deleteArtist(Artist $artist) : void
    {
        if($this->artists->contains($artist)) {
            $this->artists->removeElement($artist);
        }
    }
}
