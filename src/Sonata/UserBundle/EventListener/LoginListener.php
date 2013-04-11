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
        if ($this->security->isGranted('ROLE_SITE-ADMIN')) {
            $response = new RedirectResponse($this->router->generate('category_index'));
        } elseif ($this->security->isGranted('ROLE_ADMIN')) {
            $response = new RedirectResponse($this->router->generate('category_index'));
        } elseif ($this->security->isGranted('ROLE_USER')) {
            // redirect the user to where they were before the login process begun.
            $referer_url = $request->headers->get('referer');

            $response = new RedirectResponse($referer_url);
        }

        return $response;
    }

}