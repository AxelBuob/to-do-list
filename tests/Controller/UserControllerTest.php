<?php

namespace Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Repository\UserRepository;

class UserControllerTest extends WebTestCase
{
    public function testNotLogin()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        $this->assertResponseRedirects('http://localhost/login', 302);
    }

    public function testUsersPageForbidden()
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $anonymous = $userRepository->findOneBy(['username' => 'anonymous']);
        $client->loginUser($anonymous);
        $client->request('GET', '/users');
        $this->assertResponseStatusCodeSame(403);
    }

    public function testUsersPageSuccessFull()
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $anonymous = $userRepository->findOneBy(['username' => 'admin']);
        $client->loginUser($anonymous);
        $client->request('GET', '/users');
        $this->assertResponseStatusCodeSame(200);
    }
}