<?php
/**
 * Copyright (c) 2018. Miguel Ángel Sánchez Fernández.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Application\UseCase\Artist\Dto;

/**
 * Class AddArtistToAlbumDto
 * @package App\Application\UseCase\Artist\Dto
 */
class AddArtistDto
{
    /**
     * @var int
     */
    private $albumId;

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
     * AddArtistToAlbumDto constructor.
     * @param int $albumId
     * @param string $name
     * @param string $specialisation
     */
    public function __construct(int $albumId, string $name, string $specialisation)
    {
        $this->albumId = $albumId;
        $this->name = $name;
        $this->specialisation = $specialisation;
        $this->adding_date = new \DateTime();
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getSpecialisation(): string
    {
        return $this->specialisation;
    }

    /**
     * @return \DateTime
     */
    public function getAddingDate(): \DateTime
    {
        return $this->adding_date;
    }

    /**
     * @return int
     */
    public function getAlbumId(): int
    {
        return $this->albumId;
    }
}