<?php

namespace ToG\ForumBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdminControllerTest extends WebTestCase
{
    public function testViewdashboard()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/viewDashboard');
    }

}
