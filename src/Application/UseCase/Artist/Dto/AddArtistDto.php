<?php
/**
 * Copyright (c) 2019. Miguel Ángel Sánchez Fernández.
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
     * @var array
     */
    private $albums;

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
     * AddArtistDto constructor.
     * @param string $name
     * @param string $specialisation
     * @param array $albums
     * @throws \Exception
     */
    public function __construct(string $name, string $specialisation, array $albums = [])
    {
        $this->name = $name;
        $this->specialisation = $specialisation;
        $this->adding_date = new \DateTime();
        $this->albums = $albums;
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
     * @return array
     */
    public function getAlbums(): array
    {
        return $this->albums ?? [];
    }
}
