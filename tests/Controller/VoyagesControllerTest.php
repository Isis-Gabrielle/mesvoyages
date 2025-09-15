<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class VoyagesControllerTest extends WebTestCase{
    public function testAccesPage(){
        $client = static::createClient();
        $client->request('GET', '/voyages');
        $this->assertResponseIsSuccessful(Response::HTTP_OK);
    }
   
    public function testContenuPage(){
        $client = static::createClient();
        $crawler = $client->request('GET', '/voyages');
        $this->assertSelectorTextContains('h1', 'mes voyages');
        $this->assertSelectorTextContains('th', 'Ville');
        $this->assertCount(4, $crawler->filter('th'));
    }
    
    public function testLinkVille(){
        $client = static::createClient();
        $client->request('GET', '/voyages');
        $client->clickLink('Balclutha');
        $response = $client->getResponse();
       $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
       $uri = $client->getRequest()->server->get("REQUEST_URI");
       $this->assertEquals('/voyages/voyage/87', $uri);
    }
    
    public function testFiltreVille(){
        $client = static::createClient();
        $client->request('GET', '/voyages');
        $crawler = $client->submitForm('filtre', 
                ['recherche' => 'Akhisar'
                    ]);
        $this->assertCount(1, $crawler->filter('h5'));
        $this->assertSelectorTextContains('h5', 'Akhisar');
    }
}
