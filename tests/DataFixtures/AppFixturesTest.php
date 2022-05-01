<?php

namespace Tests\AppFixtures;

use App\Repository\TaskRepository;
use App\Repository\UserRepository;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class AppFixturesTest extends KernelTestCase
{

    protected $databaseTool;

    public function setUp(): void
    {
        parent::setUp();
        $this->databaseTool = static::getContainer()->get(DatabaseToolCollection::class)->get();
    }

    public function testIndex()
    {

        self::bootKernel();
        $container = static::getContainer();


        $this->databaseTool->loadFixtures([
            'App\DataFixtures\AppFixtures'
        ]);

        $users = $container->get(UserRepository::class)->count([]);
        $this->assertSame(2, $users);

        $tasks = $container->get(TaskRepository::class)->count([]);
        $this->assertSame(10, $tasks);


    }

}