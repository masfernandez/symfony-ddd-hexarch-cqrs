<?php
/**
 * Copyright (c) 2018. Miguel Ángel Sánchez Fernández.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Infrastructure\UserInterface\Web\Controller\Album;

use App\Application\UseCase\Album\Command\Delete\DeleteCommand;
use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class DeleteController
 * @package App\Infrastructure\UserInterface\Web\Controller\Album
 */
class DeleteController extends Controller
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
     * @param $id
     * @return RedirectResponse
     */
    public function action(Request $request, $id)
    {
        $this->commandBus->handle(new DeleteCommand($id));

        $referer = $request->headers->get('referer');
        $path = parse_url($referer, PHP_URL_PATH);
        $route = $this->get('router')->getMatcher()->match($path);
        return $this->redirectToRoute($route['_route'] ?? 'web_app_home');
    }
}