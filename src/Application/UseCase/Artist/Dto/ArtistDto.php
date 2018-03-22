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
     * @var string
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
     * @var string
     */
    private $album;

    /**
     * ArtistDto constructor.
     * @param string|null $id
     * @param string $name
     * @param string $specialisation
     * @param string|null $album
     */
    public function __construct(string $id = null, string $name, string $specialisation, string $album = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->specialisation = $specialisation;
        $this->album = $album;
    }

    /**
     * @return string
     */
    public function getId(): string
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
     * @return string
     */
    public function getAlbum(): string
    {
        return $this->album;
    }
}