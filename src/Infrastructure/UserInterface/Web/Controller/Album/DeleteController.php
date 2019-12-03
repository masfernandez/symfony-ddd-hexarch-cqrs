<?php
/**
 * Copyright (c) 2019. Miguel Ángel Sánchez Fernández.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Infrastructure\UserInterface\Web\Controller\Album;

use App\Application\UseCase\Album\Command\Delete\DeleteCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * Class DeleteController
 * @package App\Infrastructure\UserInterface\Web\Controller\Album
 */
class DeleteController extends AbstractController
{
    /**
     * @var MessageBusInterface
     */
    protected $commandBus;

    /**
     * QueryController constructor.
     * @param MessageBusInterface $commandBus
     */
    public function __construct(MessageBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @param Request $request
     * @param string $id
     * @return RedirectResponse
     */
    public function action(Request $request, $id)
    {
        $this->commandBus->dispatch(new DeleteCommand($id));

        $referer = $request->headers->get('referer');
        $path = parse_url($referer, PHP_URL_PATH);
        $route = $this->get('router')->getMatcher()->match($path);
        return $this->redirectToRoute($route['_route'] ?? 'web_home');
    }
}
