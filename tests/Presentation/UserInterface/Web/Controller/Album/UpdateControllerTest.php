<?php
/**
 * Copyright (c) 2018. Miguel Ángel Sánchez Fernández.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Tests\UserInterface\Presentation\UserInterface\Web\Controller\Album;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\DomCrawler\Link;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class UpdateAlbumTest
 * @package App\Tests\UserInterface\Framework\Album
 */
class UpdateControllerTest extends WebTestCase
{
    /**
     * @test
     */
    public function testAction()
    {
        $client = static::createClient();
        $albumName = 'Test album phpunit';
        $albumNameUpdate = 'Test album phpunit updated';

        /**
         * Get all albums
         */
        $crawler = $client->request('GET', '/album');
        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $albumsBefore = $crawler->filter('div[class="card"]')->count();

        /**
         * Add album
         */
        $crawler = $client->request('GET', '/album/new');
        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());

        // Send form
        $form = $crawler->selectButton('Submit')->form();
        $form['album[title]'] = $albumName;
        $client->submit($form);

        // Analise /album in order to look for the new album created
        $crawler = $client->request('GET', '/album');
        $albumsAfter = $crawler->filter('div[class="card"]')->count();

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $this->assertEquals($albumsAfter, $albumsBefore + 1);
        $this->assertContains(
            $albumName,
            $crawler->text()
        );

        /**
         * Update album
         */

        $crawler->filter('a[href^="/album/edit"]')->each(function($node) use ($client,$albumNameUpdate) {
            /** @var Crawler $c */
            /** @var Link $link */
            $link = $node->link();
            $crawler = $client->request('GET', $link->getUri());
            $form = $crawler->selectButton('Submit')->form();
            $form['album[title]'] = $albumNameUpdate;
            $client->submit($form);
        });

        // Analise /album in order to look for the new album updated
        $crawler = $client->request('GET', '/album');
        $albumsAfter = $crawler->filter('div[class="card"]')->count();

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $this->assertEquals($albumsAfter, $albumsBefore + 1);
        $this->assertContains(
            $albumNameUpdate,
            $crawler->text()
        );

        /**
         * Delete test albums
         */
        $crawler->filter('a[href^="/album/delete"]')->each(function($node) use ($client) {
            /** @var Crawler $node */
            /** @var Link $link */
            $link = $node->link();
            $client->click($link);
        });

        // Count albums after deletion
        $crawler = $client->request('GET', '/album');
        $albumsAfterDeletion = $crawler->filter('div[class="card"]')->count();
        $this->assertEquals($albumsAfterDeletion, $albumsAfter - 1);
    }
}