<?php
/**
 * Copyright (c) 2018. Miguel Ángel Sánchez Fernández.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Application\UseCase\Album\Dto;

use App\Domain\Model\Artist\Artist;

/**
 * Class AlbumDto
 * @package App\Application\UseCase\Album\Dto
 */
final class AlbumDto
{
    /**
     * @var string
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
     * @var Artist[]
     */
    private $artists;

    /**
     * AlbumDto constructor.
     * @param string $id
     * @param string $title
     * @param \DateTime $publishingDate
     * @param Artist[]
     */
    public function __construct(string $id, string $title, \DateTime $publishingDate, array $artists)
    {
        $this->id = $id;
        $this->title = $title;
        $this->publishingDate = $publishingDate;
        $this->artists = $artists;
    }

    /**
     * @return string
     */
    public function getId(): string
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
     * @return Artist[]
     */
    public function getArtists(): array
    {
        return $this->artists;
    }

    /**
     * @param Artist[]
     */
    public function setArtists(array $artists): void
    {
        $this->artists = $artists;
    }
}