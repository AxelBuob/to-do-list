<?php

namespace Test\Entity;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserTest extends KernelTestCase
{
    public function testValidUser()
    {
        $user = new user;
        $user->setUsername('axel');
        $user->setEmail('admin@domain.fr');
        $user->setPassword('password');

        self::bootKernel();
        $error = static::getContainer()->get('validator')->validate($user);
        $this->assertCount(0, $error);
    }
}