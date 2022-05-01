<?php

namespace Tests\Entity;

use App\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\ConstraintViolation;

class TaskTest extends KernelTestCase
{
    public function getEntity(): Task
    {
        $task =  new Task();
        $task->setTitle('Hello world!');
        $task->setContent('Lorem ipsum lorem dolor');
        return $task;
    }

    public function assertHasErrors(Task $task, int $number = 0)
    {
        self::bootKernel();
        $errors = static::getContainer()->get('validator')->validate($task);
        $messages = [];
        /**
         * @var ConstraintViolation $error
         */
        foreach($errors as $error)
        {
            $messages[] = $error->getPropertyPath() . '=>' . $error->getMessage();
        }
        $this->assertCount($number, $errors, implode(', ', $messages));
    }

    public function testValidTask()
    {
        $this->assertHasErrors($this->getEntity(), 0);  
    }

    public function testNotBlankTitle()
    {
        $task = $this->getEntity();
        $task->setTitle('');
        $this->assertHasErrors($task, 1);
    }

    public function testNotBlankContent()
    {
        $task = $this->getEntity();
        $task->setContent('');
        $this->assertHasErrors($task, 1);
    }

    public function testMaxLengthTitle()
    {
        $task = $this->getEntity();
        $task->setTitle('qdsfjnsdfhsdjfkhsdjkfsdjfghsjdfjsdgfsdgfsdfgdsgfshdgfsdghjfgsdghfjgsdhfgsdhfgsdhfgsdhfgsdghjfgd');
        $this->assertHasErrors($task, 1);
    }

}