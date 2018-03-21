<?php
/**
 * Copyright (c) 2018. Miguel Ángel Sánchez Fernández.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Domain\Model\Artist;

use App\Domain\Model\Album\Album;
use Ramsey\Uuid\Uuid;

/**
 * Artist
 */
class Artist
{
    /**
     * @var Uuid
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
     * @var \App\Domain\Model\Album\Album
     */
    private $album;

    /**
     * Artist constructor.
     * @param ArtistId $id
     * @param string $name
     * @param string $specialisation
     * @param \DateTime|null $adding_date
     * @param Album $album
     */
    public function __construct(ArtistId $id, string $name, string $specialisation, \DateTime $adding_date = null, Album $album)
    {
        $this->id = $id;
        $this->name = $name;
        $this->specialisation = $specialisation;
        $this->adding_date = $adding_date ?? new \DateTime();
        $this->album = $album;
    }

    /**
     * @param string $name
     * @param string $specialisation
     * @param Album $album
     */
    public function update(string $name, string $specialisation, Album $album)
    {
        $this->name = $name;
        $this->specialisation = $specialisation;
        $this->album = $album;
    }

    /**
     * Get id.
     *
     * @return Uuid
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get specialisation.
     *
     * @return string
     */
    public function getSpecialisation()
    {
        return $this->specialisation;
    }

    /**
     * Get album.
     *
     * @return Album
     */
    public function getAlbum(): ? Album
    {
        return $this->album;
    }
}
