<?php
/**
 * Copyright (c) 2018. Miguel Ángel Sánchez Fernández.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Infrastructure\UserInterface\Web\Controller\Artist;

use App\Application\UseCase\Artist\Dto\AddArtistDto;
use App\Application\UseCase\Artist\Dto\ArtistDto;
use App\Application\UseCase\Artist\Service\AddArtistService;
use App\Infrastructure\Framework\Symfony\Forms\ArtistType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AddController
 * @package App\Infrastructure\UserInterface\Web\Controller\Artist
 */
class AddController extends Controller
{
    /**
     * @var AddArtistService
     */
    private $addArtistToAlbum;

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * AddToAlbumController constructor.
     * @param AddArtistService $addArtistToAlbum
     * @param FormFactoryInterface $formFactory
     */
    public function __construct(AddArtistService $addArtistToAlbum, FormFactoryInterface $formFactory)
    {
        $this->addArtistToAlbum = $addArtistToAlbum;
        $this->formFactory = $formFactory;
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function action(Request $request, $id)
    {
        $form = $this->formFactory->create(ArtistType::class, new ArtistDto(null,'','',$id));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $this->addArtistToAlbum->handle(new AddArtistDto($id, $data['name'], $data['specialisation']));
            return $this->redirectToRoute('web_app_album_getall');
        }

        return $this->render('web/artist/new_artist.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}