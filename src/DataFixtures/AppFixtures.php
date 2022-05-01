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

        UserFactory::createOne([
            'roles' => ['ROLE_ADMIN'],
            'username' => 'admin',
            'email' => 'admin@domain.fr',
            'password' => 'password'
        ]);

        $this->anonymous = UserFactory::createOne([
            'roles' => ['ROLE_USER'],
            'username' => 'anonymous',
            'email' => 'amoymous@domain.fr',
            'password' => 'password'
        ]);

        TaskFactory::createMany(10, function () { 
                return ['author' => $this->anonymous];
            }
        );

        $manager->flush();
    }
}
