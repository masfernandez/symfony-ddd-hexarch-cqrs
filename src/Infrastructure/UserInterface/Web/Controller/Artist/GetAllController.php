<?php
/**
 * Copyright (c) 2018. Miguel Ángel Sánchez Fernández.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Infrastructure\UserInterface\Web\Controller\Artist;

use App\Application\UseCase\Artist\Service\GetAllArtistService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class GetAllController
 * @package App\Infrastructure\UserInterface\Web\Controller\Album
 */
class GetAllController extends Controller
{
    /**
     * @var GetAllArtistService
     */
    private $getAllArtistsService;

    /**
     * DeleteController constructor.
     * @param GetAllArtistService $getAllArtistsService
     */
    public function __construct(GetAllArtistService $getAllArtistsService)
    {
        $this->getAllArtistsService = $getAllArtistsService;
    }

    /**
     * @return Response
     */
    public function action()
    {
        $artist = $this->getAllArtistsService->handle();
        return $this->render('web/artist/get_all.html.twig', [
            'artists' => $artist
        ]);
    }
}