<?php

namespace AppBundle\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Entity\Task;

class TaskRegistration
{
    /**
     * @Assert\Type(type="AppBundle\Entity\Task")
     * @Assert\Valid()
     */
    protected $task;

    public function setTask(Task $task)
    {
        $this->task = $task;
    }

    public function getTask()
    {
        return $this->task;
    }
}