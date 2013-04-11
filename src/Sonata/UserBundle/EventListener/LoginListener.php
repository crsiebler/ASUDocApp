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
            $response = new RedirectResponse($this->router->generate('user_site-admin_splash'));
        } elseif ($this->security->isGranted('ROLE_ADMIN')) {
            // Redirect to Office-Admin Splash Page
            $response = new RedirectResponse($this->router->generate('user_admin_splash'));
        } elseif ($this->security->isGranted('ROLE_PATIENT')) {
            // Redirect to Patient Splash Page
            $response = new RedirectResponse($this->router->generate('user_patient_splash'));
        } elseif ($this->security->isGranted('ROLE_DOCTOR')) {
            // Redirect to Doctor Splash Page
            $response = new RedirectResponse($this->router->generate('user_doctor_splash'));
        } elseif ($this->security->isGranted('ROLE_NURSE')) {
            // Redirect to Nurse Splash Page
            $response = new RedirectResponse($this->router->generate('user_nurse_splash'));
        } elseif ($this->security->isGranted('ROLE_EMT')) {
            // Redirect to EMT Splash Page
            $response = new RedirectResponse($this->router->generate('user_emt_splash'));
        } elseif ($this->security->isGranted('ROLE_USER')) {
            // Should not occur!!!
            // Redirect to homepage if Role not given
            $response = new RedirectResponse($this->router->generate('homepage'));
        }

        return $response;
    }

}