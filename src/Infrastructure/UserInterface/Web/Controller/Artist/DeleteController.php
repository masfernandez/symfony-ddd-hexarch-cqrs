<?php
/**
 * Copyright (c) 2018. Miguel Ángel Sánchez Fernández.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Infrastructure\UserInterface\Web\Controller\Artist;

use App\Application\UseCase\Artist\Dto\DeleteArtistDto;
use App\Application\UseCase\Artist\Service\DeleteArtistService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class DeleteController
 * @package App\Infrastructure\UserInterface\Web\Controller\Artist
 */
class DeleteController extends Controller
{
    /**
     * @var DeleteArtistService
     */
    private $deleteArtistService;

    /**
     * DeleteController constructor.
     * @param DeleteArtistService $deleteAlbumService
     */
    public function __construct(DeleteArtistService $deleteAlbumService)
    {
        $this->deleteArtistService = $deleteAlbumService;
    }

    /**
     * @param Request $request
     * @param $id
     * @return RedirectResponse|Response
     */
    public function action(Request $request, $id)
    {
        try {
            $this->deleteArtistService->handle(new DeleteArtistDto($id));
        } catch (NotFoundHttpException $ex) {
            return $this->render('web/artist/not_found_artist.html.twig');
        }

        $referer = $request->headers->get('referer');
        $path = parse_url($referer, PHP_URL_PATH);
        $route = $this->get('router')->getMatcher()->match($path);
        return $this->redirectToRoute($route['_route'] ?? 'web_app_home');
    }
}