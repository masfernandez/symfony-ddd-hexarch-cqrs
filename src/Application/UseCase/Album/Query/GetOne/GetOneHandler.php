<?php
/**
 * Copyright (c) 2018. Miguel Ángel Sánchez Fernández.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Application\UseCase\Album\Query\GetOne;

use App\Application\UseCase\Album\Dto\AlbumDto;
use App\Domain\Bus\QueryHandlerInterface;
use App\Domain\Model\Album\AlbumRepositoryInterface;
use App\Domain\Model\Album\Exception\AlbumException;

/**
 * Class GetOneHandler
 * @package App\Application\UseCase\Album\Query\GetOne
 */
class GetOneHandler implements QueryHandlerInterface
{
    /**
     * @var AlbumRepositoryInterface
     */
    private $albumRepository;

    /**
     * AddAlbumService constructor.
     * @param AlbumRepositoryInterface $albumRepository
     */
    public function __construct(AlbumRepositoryInterface $albumRepository)
    {
        $this->albumRepository = $albumRepository;
    }

    /**
     * @param GetOneQuery $query
     * @return AlbumDto
     * @throws AlbumException
     */
    public function handle(GetOneQuery $query)
    {
        try {
            $album = $this->albumRepository->findOne($query->id);
        } catch (AlbumException $ex) {
            throw $ex;
        }

        return new AlbumDto(
            $album->getId(),
            $album->getTitle(),
            $album->getPublishingDate(),
            (array)$album->getArtists()
        );
    }
}