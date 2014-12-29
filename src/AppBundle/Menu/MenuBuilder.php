<?php
// src/AppBundle/Menu/MenuBuilder.php

namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\Request;

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

    public function superiorMenu(Request $request)
    {
        $menu = $this->factory->createItem('root');
    
        // account menu and submenus
        $menu->addChild('account', array('label' => 'Hi '. $request->get('username', 'anonymous')))
            ->setAttribute('dropdown', true)
            ->setCurrent(false);

        $menu['account']->addChild('Profile', array('route' => 'homepage'))
            ->setCurrent(false);
        $menu['account']->addChild('Preferences', array('route' => 'homepage'))
            ->setCurrent(false);
        $menu['account']->addChild('', array())     // define a horizontal divider
            ->setAttribute('class', 'divider');
        $menu['account']->addChild('Sign in', array('route' => 'homepage'))
            ->setCurrent(false);
        
        return $menu;
    }

    public function appMenu(Request $request)
    {
        $menu = $this->factory->createItem('root');
    
        // dashboard
        $menu->addChild('Dashboard', array('route' => 'homepage'));

        // catalogues menu and submenus
        $menu->addChild('Catalogues', array('route' => 'homepage'))
            ->setAttribute('dropdown', true)
            ->setCurrent(false);
        
        $menu['Catalogues']->addChild('Categories', array('route' => 'homepage'))
            ->setCurrent(false);
        $menu['Catalogues']->addChild('Accounts', array('route' => 'homepage'))
            ->setCurrent(false);
        $menu['Catalogues']->addChild('Prices', array('route' => 'homepage'))
            ->setCurrent(false);
        $menu['Catalogues']->addChild('Members', array('route' => 'homepage'))
            ->setCurrent(false);
        $menu['Catalogues']->addChild('Templates', array('route' => 'homepage'))
            ->setCurrent(false);

        // finances menu and submenus
        $menu->addChild('Finances', array('route' => 'homepage'))
            ->setAttribute('dropdown', true)
            ->setCurrent(false);

        // plan menu
        $menu['Finances']->addChild('Plans', array('route' => 'homepage'))
            ->setCurrent(false);

        // transactions menu
        $menu['Finances']->addChild('Transactions', array('route' => 'homepage'))
            ->setCurrent(false);

        // controls menu
        $menu['Finances']->addChild('Controls', array('route' => 'homepage'))
            ->setCurrent(false);

        // tools menu and submenus
        $menu->addChild('Tools', array('route' => 'homepage'))
            ->setAttribute('dropdown', true)
            ->setCurrent(false);

        $menu['Tools']->addChild('Scheduler', array('route' => 'homepage'))
            ->setCurrent(false);
        $menu['Tools']->addChild('Simulator', array('route' => 'homepage'))
            ->setCurrent(false);
        $menu['Tools']->addChild('Analyzer', array('route' => 'homepage'))
            ->setCurrent(false);
        
        return $menu;
    }
}