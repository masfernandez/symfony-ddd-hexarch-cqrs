<?php
/**
 * Copyright (c) 2018. Miguel Ángel Sánchez Fernández.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Application\UseCase\Artist\Dto;

/**
 * Class ArtistDto
 * @package App\Application\UseCase\Artist\Dto
 */
class ArtistDto
{
    /**
     * @var int
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
     * @var int
     */
    private $album;

    /**
     * ArtistDto constructor.
     * @param int $id
     * @param string $name
     * @param string $specialisation
     * @param int $album
     */
    public function __construct(int $id = null, string $name, string $specialisation, int $album = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->specialisation = $specialisation;
        $this->album = $album;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
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
     * @return int
     */
    public function getAlbum(): int
    {
        return $this->album;
    }
}