<?php
/**
 * Copyright (c) 2018. Miguel Ángel Sánchez Fernández.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Infrastructure\UserInterface\Web\Controller\Album;

use App\Application\UseCase\Album\Command\Update\UpdateCommand;
use App\Application\UseCase\Album\Query\GetOne\GetOneQuery;
use App\Infrastructure\Framework\Symfony\Forms\AlbumType;
use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class UpdateController
 * @package App\Infrastructure\UserInterface\Web\Controller\Album
 */
class UpdateController extends Controller
{
    /**
     * @var CommandBus
     */
    protected $queryBus;
    /**
     * @var CommandBus
     */
    private $commandBus;
    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * UpdateController constructor.
     * @param CommandBus $commandBus
     * @param CommandBus $queryBus
     * @param FormFactoryInterface $formFactory
     */
    public function __construct(CommandBus $commandBus, CommandBus $queryBus, FormFactoryInterface $formFactory)
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
        $albumDto = $this->queryBus->handle(new GetOneQuery($id));
        $form = $this->formFactory->create(AlbumType::class, $albumDto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $this->commandBus->handle(new UpdateCommand($id, $data['title'], $data['publishing_date']));
            return $this->redirectToRoute('web_app_album_getall');
        }

        return $this->render('web/album/update_album.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}