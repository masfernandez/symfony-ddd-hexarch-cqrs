<?php
/**
 * Copyright (c) 2018. Miguel Ángel Sánchez Fernández.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Application\UseCase\Artist\Dto;

/**
 * Class UpdateArtistDto
 * @package App\Application\UseCase\Artist\Dto
 */
class UpdateArtistDto
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
    private $albumId;

    /**
     * UpdateArtistDto constructor.
     * @param int $id
     * @param string $name
     * @param string $specialisation
     * @param int $albumId
     */
    public function __construct(int $id, string $name, string $specialisation, int $albumId)
    {
        $this->id = $id;
        $this->name = $name;
        $this->specialisation = $specialisation;
        $this->albumId = $albumId;
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
    public function getAlbumId(): int
    {
        return $this->albumId;
    }
}