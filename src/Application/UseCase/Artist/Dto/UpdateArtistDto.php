<?php
/**
 * Copyright (c) 2019. Miguel Ángel Sánchez Fernández.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Application\UseCase\Artist\Dto;

use App\Domain\Model\Artist\ArtistId;

/**
 * Class UpdateArtistDto
 * @package App\Application\UseCase\Artist\Dto
 */
class UpdateArtistDto
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
     * UpdateArtistDto constructor.
     * @param string $id
     * @param string $name
     * @param string $specialisation
     * @throws \Exception
     */
    public function __construct(string $id, string $name, string $specialisation)
    {
        $this->id = new ArtistId($id);
        $this->name = $name;
        $this->specialisation = $specialisation;
    }

    /**
     * @return ArtistId
     */
    public function getId(): ArtistId
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
}
