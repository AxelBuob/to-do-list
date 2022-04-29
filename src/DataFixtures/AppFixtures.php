<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Factory\TaskFactory;
use App\Factory\UserFactory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        //TaskFactory::createMany(10);

        //UserFactory::createMany(10);

        UserFactory::createOne([
            'roles' => ['ROLE_ADMIN'],
            'username' => 'admin',
            'email' => 'admin@todo-co.fr',
            'password' => 'password'
        ]);

        UserFactory::createOne([
            'roles' => ['ROLE_USER'],
            'username' => 'anonymous',
            'email' => 'amoymous@todo-co.fr',
            'password' => 'password'
        ]);

        TaskFactory::createMany(20, function () {
            return [
                'author' => UserFactory::random()
            ];
        });


        $manager->flush();
    }
}
