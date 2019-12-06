<?php
/**
 * Copyright (c) 2018. Miguel Ángel Sánchez Fernández.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Application\UseCase\Album\Command\Delete;

use App\Domain\Bus\CommandInterface;
use App\Domain\Model\Album\AlbumId;
use App\Domain\Model\Artist\ArtistId;

/**
 * Class DeleteArtistFromAlbumCommand
 * @package App\Application\UseCase\Album\Command\Delete
 */
final class DeleteArtistFromAlbumCommand implements CommandInterface
{
    /**
     * @var AlbumId
     */
    public $albumId;

    /**
     * @var ArtistId
     */
    public $artistId;

    /**
     * DeleteCommand constructor.
     * @param string $albumId
     * @param string $artistId
     */
    public function __construct(string $albumId, string $artistId)
    {
        $this->albumId = new AlbumId($albumId);
        $this->artistId = new ArtistId($artistId);
    }
}