<?php

namespace Sonata\SecurityBundle\NavBar;

use Mopa\Bundle\BootstrapBundle\Navbar\AbstractNavbarMenuBuilder;
use Knp\Menu\FactoryInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\HttpFoundation\Request;

class MenuBuilder extends AbstractNavbarMenuBuilder {

    protected $isLoggedIn;
    protected $session;
    protected $user;

    public function __construct(FactoryInterface $factory, SecurityContextInterface $securityContext, $session) {
        parent::__construct($factory);

        $this->user = $securityContext->getToken()->getUser();
        $this->isLoggedIn = $securityContext->isGranted('IS_AUTHENTICATED_FULLY');
        $this->session = $session;
    }

    public function createMainMenu(Request $request) {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav');

        if ($this->isLoggedIn) {
            if ($this->user->hasRoleByName("ROLE_PATIENT")) {
                $menu->addChild('Patient', array(
                    'route' => 'user_show',
                    'routeParameters' => array('id' => $this->user->getId())
                ));
            } elseif ($this->user->hasRoleByName("ROLE_DOCTOR")) {
                $menu->addChild('Doctor', array(
                    'route' => 'user_show',
                    'routeParameters' => array('id' => $this->user->getId())
                ));
            } elseif ($this->user->hasRoleByName("ROLE_NURSE")) {
                $menu->addChild('Nurse', array(
                    'route' => 'user_show',
                    'routeParameters' => array('id' => $this->user->getId())
                ));
            } elseif ($this->user->hasRoleByName("ROLE_ADMIN")) {
                $menu->addChild('Admin', array(
                    'route' => 'user_show',
                    'routeParameters' => array('id' => $this->user->getId())
                ));
            } elseif ($this->user->hasRoleByName("ROLE_EMT")) {
                $menu->addChild('EMT', array(
                    'route' => 'user_show',
                    'routeParameters' => array('id' => $this->user->getId())
                ));
            } elseif ($this->user->hasRoleByName("ROLE_SITE-ADMIN")) {
                $menu->addChild('Site-Admin', array(
                    'route' => 'user_show',
                    'routeParameters' => array('id' => $this->user->getId())
                ));
            }
        } else {
            $dropdown = $this->createDropdownMenuItem($menu, "Developers", false, array('caret' => true));
            $dropdown->addChild('Cory Siebler', array('uri' => 'http://www.linkedin.com/in/corysiebler/'));
            $this->addDivider($dropdown);
            $dropdown->addChild('Kyle Rota', array('uri' => 'http://www.linkedin.com/pub/kyle-rota/14/955/947'));
            $this->addDivider($dropdown);
            $dropdown->addChild('Bryan Garcia', array('uri' => 'http://www.linkedin.com/pub/bryan-garcia/59/563/126'));
            $this->addDivider($dropdown);
            $dropdown->addChild('Peter Tinsley', array('uri' => 'http://www.linkedin.com/pub/peter-tinsley/59/372/b70'));
            $this->addDivider($dropdown);
            $dropdown->addChild('Ben Prather', array('uri' => 'http://www.google.com/search?q=Ben+Prather'));
        }

        return $menu;
    }

    public function createRightSideDropdownMenu(Request $request) {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav pull-right');

        if ($this->isLoggedIn) {
            $menu->addChild('Logout', array('route' => 'fos_user_security_logout'));
        } else {
            $menu->addChild('Login', array('route' => 'fos_user_security_login'));
        }

        return $menu;
    }

    public function createNavbarsSubnavMenu(Request $request) {
        $menu = $this->createSubnavbarMenuItem();

        return $menu;
    }

    public function createComponentsSubnavMenu(Request $request) {
        $menu = $this->createSubnavbarMenuItem();

        return $menu;
    }
}