<?php
/**
 * Copyright (c) 2018. Miguel Ángel Sánchez Fernández.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Tests\UserInterface\Presentation\UserInterface\Web\Controller\Home;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class HomeControllerTest
 * @package App\Tests\UserInterface\Home
 */
class HomeControllerTest extends WebTestCase
{
    /**
     * Functional test Home
     */
    public function testAction()
    {
        $client = static::createClient();
        $client->request('GET', '/');
        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }
}