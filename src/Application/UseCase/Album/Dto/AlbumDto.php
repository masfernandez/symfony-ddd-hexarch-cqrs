<?php
/**
 * Copyright (c) 2018. Miguel Ángel Sánchez Fernández.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Application\UseCase\Album\Dto;

use Doctrine\Common\Collections\Collection;

/**
 * Class AlbumDto
 * @package App\Application\UseCase\Album\Dto
 */
final class AlbumDto
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var \DateTime
     */
    private $publishingDate;

    /**
     * @var array
     */
    private $artists;

    /**
     * AlbumDto constructor.
     * @param int $id
     * @param string $title
     * @param \DateTime $publishingDate
     * @param Collection $artists
     */
    public function __construct(int $id, string $title, \DateTime $publishingDate, Collection $artists)
    {
        $this->id = $id;
        $this->title = $title;
        $this->publishingDate = $publishingDate;
        $this->artists = $artists;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return \DateTime
     */
    public function getPublishingDate(): \DateTime
    {
        return $this->publishingDate;
    }

    /**
     * @param \DateTime $publishingDate
     */
    public function setPublishingDate(\DateTime $publishingDate): void
    {
        $this->publishingDate = $publishingDate;
    }

    /**
     * @return Collection
     */
    public function getArtists(): Collection
    {
        return $this->artists;
    }

    /**
     * @param array $artists
     */
    public function setArtists(array $artists): void
    {
        $this->artists = $artists;
    }
}