<?php
/**
 * Copyright (c) 2019. Miguel Ángel Sánchez Fernández.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Infrastructure\UserInterface\Web\Controller\Album;

use App\Application\UseCase\Album\Query\GetAll\GetAllQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

/**
 * Class GetAllController
 * @package App\Infrastructure\UserInterface\Web\Controller\Album
 */
class GetAllController extends AbstractController
{
    /**
     * @var MessageBusInterface
     */
    protected $queryBus;

    /**
     * QueryController constructor.
     * @param MessageBusInterface $queryBus
     */
    public function __construct(MessageBusInterface $queryBus)
    {
        $this->queryBus = $queryBus;
    }

    /**
     * @return Response
     */
    public function action()
    {
        /** @var HandledStamp $handlerResult */
        $handlerResult = $this->queryBus->dispatch(new GetAllQuery())->last(HandledStamp::class);
        $albums = $handlerResult->getResult();
        return $this->render('web/album/get_all.html.twig', [
            'albums' => $albums
        ]);
    }
}
