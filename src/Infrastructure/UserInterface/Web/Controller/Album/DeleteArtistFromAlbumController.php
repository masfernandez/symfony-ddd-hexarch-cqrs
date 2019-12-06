<?php
/**
 * Copyright (c) 2018. Miguel Ángel Sánchez Fernández.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Infrastructure\UserInterface\Web\Controller\Album;

use App\Application\UseCase\Album\Command\Delete\DeleteArtistFromAlbumCommand;
use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class DeleteArtistFromAlbumController
 * @package App\Infrastructure\UserInterface\Web\Controller\Album
 */
class DeleteArtistFromAlbumController extends Controller
{
    /**
     * @var CommandBus
     */
    protected $commandBus;

    /**
     * QueryController constructor.
     * @param CommandBus $commandBus
     */
    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @param Request $request
     * @param string $albumId
     * @param string $artistId
     * @return RedirectResponse
     */
    public function action(Request $request, $albumId, $artistId)
    {
        $this->commandBus->handle(new DeleteArtistFromAlbumCommand($albumId, $artistId));
        $referer = $request->headers->get('referer');
        $path = parse_url($referer, PHP_URL_PATH);
        $route = $this->get('router')->getMatcher()->match($path);
        return $this->redirectToRoute($route['_route'] ?? 'web_home');
    }
}