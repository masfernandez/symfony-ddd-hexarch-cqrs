<?php
/**
 * Copyright (c) 2018. Miguel Ángel Sánchez Fernández.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Infrastructure\UserInterface\Web\Controller\Album;

use App\Application\UseCase\Album\Query\GetAll\GetAllQuery;
use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class GetAllController
 * @package App\Infrastructure\UserInterface\Web\Controller\Album
 */
class GetAllController extends Controller
{
    /**
     * @var CommandBus
     */
    protected $queryBus;

    /**
     * QueryController constructor.
     * @param CommandBus $queryBus
     */
    public function __construct(CommandBus $queryBus)
    {
        $this->queryBus = $queryBus;
    }

    /**
     * @return Response
     */
    public function action()
    {
        $albums = $this->queryBus->handle(new GetAllQuery());
        return $this->render('web/album/get_all.html.twig', [
            'albums' => $albums
        ]);
    }
}