<?php
/**
 * Copyright (c) 2019. Miguel Ángel Sánchez Fernández.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Infrastructure\UserInterface\Web\Controller\Album;

use App\Application\UseCase\Album\Command\Update\UpdateCommand;
use App\Application\UseCase\Album\Dto\AlbumDto;
use App\Application\UseCase\Album\Query\GetOne\GetOneQuery;
use App\Infrastructure\Framework\Symfony\Forms\AlbumType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

/**
 * Class UpdateController
 * @package App\Infrastructure\UserInterface\Web\Controller\Album
 */
class UpdateController extends AbstractController
{
    /**
     * @var MessageBusInterface
     */
    protected $queryBus;
    /**
     * @var MessageBusInterface
     */
    private $commandBus;
    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * UpdateController constructor.
     * @param MessageBusInterface $commandBus
     * @param MessageBusInterface $queryBus
     * @param FormFactoryInterface $formFactory
     */
    public function __construct(MessageBusInterface $commandBus, MessageBusInterface $queryBus, FormFactoryInterface $formFactory)
    {
        $this->commandBus = $commandBus;
        $this->queryBus = $queryBus;
        $this->formFactory = $formFactory;
    }

    /**
     * @param Request $request
     * @param $id
     * @return RedirectResponse|Response
     */
    public function action(Request $request, $id)
    {
        /** @var HandledStamp $handlerResult */
        $handlerResult = $this->queryBus->dispatch(new GetOneQuery($id))->last(HandledStamp::class);
        $albumDto = $handlerResult->getResult();
        $form = $this->formFactory->create(AlbumType::class, [
            'title' => $albumDto->getTitle(),
            'publishing_date' => $albumDto->getPublishingDate()
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $this->commandBus->dispatch(new UpdateCommand($id, $data['title'], $data['publishing_date']));
            return $this->redirectToRoute('web_album_getall');
        }

        return $this->render('web/album/update_album.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
