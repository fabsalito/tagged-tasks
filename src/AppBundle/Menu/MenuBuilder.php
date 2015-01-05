<?php
// src/AppBundle/Menu/MenuBuilder.php

namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;

class MenuBuilder
{
    private $factory;

    /**
     * @param FactoryInterface $factory
     */
    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public function superiorMenu(Request $request, SecurityContext $securityContext)
    {
        $user = $securityContext->getToken()->getUser();

        if (is_object($user)){
            $username = $user->getUsername();
        }

        $menu = $this->factory->createItem('root');
        //$menu->setChildrenAttribute('class', 'nav pull-right');

        // add atsk menu
        $menu->addChild('add_task', array('route' => 'homepage', 
                                          //'label' => '<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>',
                                          //'extras' => array('safe_label' => true)));
                                          'label' => 'Add task'))
            ->setCurrent(false);
                                          

        // account menu and submenus
        $menu->addChild('account', array('label' => 'Hi '. (is_object($user) ? $username : 'visitor')))
        //$menu->addChild('account')
        //    ->setUri('#')
        //    ->setAttribute('class', 'dropdown')
        //    ->setLabel('Hi '. $request->get('username', 'visitor') . ' <span class="caret"></span>')
        //    ->setExtra('safe_label', true)
        //    //->setLabelAttribute('class', 'caret')
        //    ->setLinkAttributes(array('class'=>'dropdown-toggle', 
        //                              'data-toggle'=>'dropdown', 
        //                              'role'=>'button', 
        //                              'aria-expanded'=>'false'))
        //    ->setChildrenAttribute('class', 'dropdown-menu')
        //    ->setChildrenAttribute('role', 'menu')
            ->setAttribute('dropdown', true)
            ->setCurrent(false);

        $menu['account']->addChild('Profile', array('route' => 'homepage'))
            ->setCurrent(false);
        $menu['account']->addChild('Preferences', array('route' => 'homepage'))
            ->setCurrent(false);
        $menu['account']->addChild('', array())     // define a horizontal divider
            ->setAttribute('class', 'divider');
        if (is_object($user)){
            $menu['account']->addChild('Sign out', array('route' => 'logout'))
                ->setCurrent(false);
        }
        else {
            $menu['account']->addChild('Sign in', array('route' => 'login'))
                ->setCurrent(false);   
        }
        
        return $menu;
    }

}