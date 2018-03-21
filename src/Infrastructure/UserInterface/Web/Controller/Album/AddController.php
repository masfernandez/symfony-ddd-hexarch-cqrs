<?php
/**
 * Copyright (c) 2018. Miguel Ángel Sánchez Fernández.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Infrastructure\UserInterface\Web\Controller\Album;

use App\Application\UseCase\Album\Command\Add\AddCommand;
use App\Infrastructure\Framework\Symfony\Forms\AlbumType;
use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AddController
 * @package App\Infrastructure\UserInterface\Web\Controller\Album
 */
class AddController extends Controller
{
    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * AddController constructor.
     * @param CommandBus $commandBus
     * @param FormFactoryInterface $formFactory
     */
    public function __construct(CommandBus $commandBus, FormFactoryInterface $formFactory)
    {
        $this->commandBus = $commandBus;
        $this->formFactory = $formFactory;
    }

    /**
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function action(Request $request)
    {
        $form = $this->formFactory->create(AlbumType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $this->commandBus->handle(new AddCommand($data['title'], $data['publishing_date']));
            return $this->redirectToRoute('web_app_album_getall');
        }

        return $this->render('web/album/new_album.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}