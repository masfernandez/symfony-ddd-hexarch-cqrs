<?php
/**
 * Copyright (c) 2019. Miguel Ángel Sánchez Fernández.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Infrastructure\UserInterface\Web\Controller\Home;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class HomeController
 * @package App\Infrastructure\UserInterface\Web\Controller\Home
 */
class HomeController extends AbstractController
{
    /**
     * @return Response
     */
    public function action()
    {
        // $this->addFlash() is equivalent to $request->getSession()->getFlashBag()->add()
        return $this->render('web/home/home.html.twig');
    }
}
