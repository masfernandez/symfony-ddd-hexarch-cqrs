<?php
/**
 * Copyright (c) 2018. Miguel Ángel Sánchez Fernández.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Application\UseCase\Artist\Dto;
use Doctrine\ORM\PersistentCollection;

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
     * @var array
     */
    private $albums;

    /**
     * ArtistDto constructor.
     * @param string|null $id
     * @param string $name
     * @param string $specialisation
     * @param array $albums
     */
    public function __construct(string $id = null, string $name, string $specialisation, array $albums = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->specialisation = $specialisation;
        $this->albums = $albums;
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
     * @return array
     */
    public function getAlbums(): array
    {
        return $this->albums;
    }
}