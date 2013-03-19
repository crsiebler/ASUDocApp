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

        return $menu;
    }

    public function createRightSideDropdownMenu(Request $request) {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav pull-right');

        if (!$this->isLoggedIn) {
            $menu->addChild('Login', array('route' => 'fos_user_security_login'));
        } else {
            $menu->addChild('Logout', array('route' => 'fos_user_security_logout'));
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