<?php
/**
 * Copyright (c) 2019. Miguel Ángel Sánchez Fernández.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Infrastructure\UserInterface\Web\Controller\Album;

use App\Application\UseCase\Album\Command\Add\AddCommand;
use App\Infrastructure\Framework\Symfony\Forms\AlbumType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * Class AddController
 * @package App\Infrastructure\UserInterface\Web\Controller\Album
 */
class AddController extends AbstractController
{
    /**
     * @var MessageBusInterface
     */
    private $commandBus;

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * AddController constructor.
     * @param MessageBusInterface $commandBus
     * @param FormFactoryInterface $formFactory
     */
    public function __construct(MessageBusInterface $commandBus, FormFactoryInterface $formFactory)
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
            $this->commandBus->dispatch(new AddCommand($data['title'], $data['publishing_date']));
            $this->addFlash('success', 'Album created!');
            return $this->redirectToRoute('web_album_getall');
        }

        return $this->render('web/album/add_album.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
