<?php
/**
 * Copyright (c) 2018. Miguel Ángel Sánchez Fernández.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Domain\Model\Album;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

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
     * @var ArrayCollection
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
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Get publishingDate.
     *
     * @return \DateTime
     */
    public function getPublishingDate()
    {
        return $this->publishing_date;
    }

    /**
     * Get artists.
     *
     * @return Collection
     */
    public function getArtists()
    {
        return $this->artists->toArray();
    }
}
