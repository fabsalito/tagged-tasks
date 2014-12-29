<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use AppBundle\EventListener\CreateUserSubscriber;

class UserRegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('user', new UserType());
        $builder->add(
            'terms',
            'checkbox',
            array('property_path' => 'termsAccepted')
        );
        $builder->addEventSubscriber(new CreateUserSubscriber());
        $builder->add('Register', 'submit');
    }

    public function getName()
    {
        return 'user_registration';
    }
}