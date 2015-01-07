<?php

namespace AppBundle\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use AppBundle\Entity\Task;

class TaskRegistration
{

    public function __construct()
    {
        $this->tags = new ArrayCollection();
    }

    /**
     * @Assert\Type(type="AppBundle\Entity\Task")
     * @Assert\Valid()
     */
    protected $task;

    protected $tags;

    public function setTask(Task $task)
    {
        $this->task = $task;
    }

    public function getTask()
    {
        return $this->task;
    }

    public function setTags(Tags $tags)
    {
        $this->tags = $tags;
    }

    public function getTags()
    {
        return $this->tags;
    }
}