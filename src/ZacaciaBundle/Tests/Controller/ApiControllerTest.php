<?php

namespace ZacaciaBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApiControllerTest extends WebTestCase
{
    public function testCheckplatform()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/check/platform');
    }

}
