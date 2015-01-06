<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class TaskRegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('Task', new TaskType());
        $builder->add('Create', 'submit');
    }

    public function getName()
    {
        return 'task_registration';
    }
}