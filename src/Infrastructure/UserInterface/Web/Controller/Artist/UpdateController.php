<?php
/**
 * Copyright (c) 2018. Miguel Ángel Sánchez Fernández.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Infrastructure\UserInterface\Web\Controller\Artist;

use App\Application\UseCase\Artist\Dto\FindOneArtistDto;
use App\Application\UseCase\Artist\Dto\UpdateArtistDto;
use App\Application\UseCase\Artist\Service\FindOneArtistService;
use App\Application\UseCase\Artist\Service\UpdateArtistService;
use App\Infrastructure\Framework\Symfony\Forms\ArtistType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class UpdateController
 * @package App\Infrastructure\UserInterface\Web\Controller\Artist
 */
class UpdateController extends Controller
{
    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var FindOneArtistService
     */
    private $findOneArtistService;

    /**
     * @var UpdateArtistService
     */
    private $updateArtistService;

    /**
     * UpdateController constructor.
     * @param UpdateArtistService $updateArtistService
     * @param FindOneArtistService $findOneArtistService
     * @param FormFactoryInterface $formFactory
     */
    public function __construct(UpdateArtistService $updateArtistService,
                                FindOneArtistService $findOneArtistService,
                                FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
        $this->findOneArtistService = $findOneArtistService;
        $this->updateArtistService = $updateArtistService;
    }

    /**
     * @param Request $request
     * @param $id
     * @return RedirectResponse|Response
     */
    public function action(Request $request, $id)
    {
        $artistDto = $this->findOneArtistService->handle(new FindOneArtistDto($id));
        $form = $this->formFactory->create(ArtistType::class, [
            'name' => $artistDto->getName(),
            'specialisation' => $artistDto->getName(),
            //'albumId' => $artistDto->getAlbums(),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $this->updateArtistService->handle(new UpdateArtistDto(
                $id,
                $data['name'],
                $data['specialisation'],
                $data['albumId']
            ));
            return $this->redirectToRoute('web_artist_getAll');
        }

        return $this->render('web/artist/update_artist.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}