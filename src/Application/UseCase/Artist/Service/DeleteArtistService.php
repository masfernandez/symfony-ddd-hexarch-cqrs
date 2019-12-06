<?php
/**
 * Copyright (c) 2019. Miguel Ángel Sánchez Fernández.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Application\UseCase\Artist\Service;

use App\Application\UseCase\Artist\Dto\DeleteArtistDto;
use App\Domain\Model\Artist\ArtistRepositoryInterface;
use App\Domain\Model\Artist\Exception\ArtistException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class DeleteArtistService
 * @package App\Application\UseCase\Artist\Service
 */
class DeleteArtistService
{
    /**
     * @var ArtistRepositoryInterface
     */
    private $artistRepository;

    /**
     * UpdateArtistService constructor.
     * @param ArtistRepositoryInterface $artistRepository
     */
    public function __construct(ArtistRepositoryInterface $artistRepository)
    {
        $this->artistRepository = $artistRepository;
    }

    /**
     * @param DeleteArtistDto $dto
     * @throws NotFoundHttpException
     */
    public function handle($dto)
    {
        try {
            $this->artistRepository->remove($dto->getArtistId());
        } catch (ArtistException $ex) {
            throw new NotFoundHttpException();
        }
    }
}
