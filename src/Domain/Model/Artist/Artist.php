<?php
/**
 * Copyright (c) 2018. Miguel Ángel Sánchez Fernández.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Domain\Model\Artist;

use App\Domain\Model\Album\Album;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;

/**
 * Artist
 */
class Artist
{
    /**
     * @var ArtistId
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $specialisation;

    /**
     * @var \DateTime
     */
    private $adding_date;

    /**
     * @var PersistentCollection
     */
    private $albums;

    /**
     * Artist constructor.
     * @param ArtistId $id
     * @param string $name
     * @param string $specialisation
     * @param \DateTime|null $adding_date
     */
    public function __construct(ArtistId $id, string $name, string $specialisation, \DateTime $adding_date = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->specialisation = $specialisation;
        $this->adding_date = $adding_date ?? new \DateTime();
        $this->albums = new ArrayCollection();
    }

    /**
     * @param string $name
     * @param string $specialisation
     */
    public function update(string $name, string $specialisation)
    {
        $this->name = $name;
        $this->specialisation = $specialisation;
    }

    /**
     * Get id.
     *
     * @return ArtistId
     */
    public function getId() : ArtistId
    {
        return $this->id;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * Get specialisation.
     *
     * @return string
     */
    public function getSpecialisation() : string
    {
        return $this->specialisation;
    }

    /**
     * @return PersistentCollection
     */
    public function getAlbums(): PersistentCollection
    {
        return $this->albums;
    }

    /**
     * @param Album $album
     */
    public function addAlbum(Album $album): void
    {
        $this->albums->add($album);
    }

    /**
     * @param Album $album
     */
    public function deleteAlbum(Album $album) : void
    {
        if($this->albums->contains($album)) {
            $this->albums->removeElement($album);
        }
    }
}
