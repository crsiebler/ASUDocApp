<?php

namespace Sonata\UserBundle\EventListener;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;


class LoginListener implements AuthenticationSuccessHandlerInterface {

    protected $router;
    protected $security;

    public function __construct(UrlGeneratorInterface $router, SecurityContext $security) {
        $this->router = $router;
        $this->security = $security;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token) {
        if ($this->security->isGranted('ROLE_USER')) {
            $response = new RedirectResponse($this->router->generate('user_splash'));
        }

        return $response;
    }

}