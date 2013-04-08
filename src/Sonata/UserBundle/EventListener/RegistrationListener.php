<?php

namespace Sonata\UserBundle\EventListener;

use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\UserEvent;
use FOS\UserBundle\Doctrine\UserManager;
use Doctrine\ORM\EntityManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Description of RegistrationListener
 *
 * @author csiebler
 */
class RegistrationListener implements EventSubscriberInterface {
    private $em;
    private $userManager;
    private $router;
    private $user;

    public function __construct(EntityManager $em, UserManager $userManager, UrlGeneratorInterface $router) {
        $this->em = $em;
        $this->userManager = $userManager;
        $this->router = $router;
        $this->user = null;
    }

    public static function getSubscribedEvents() {
        return array(
            FOSUserEvents::REGISTRATION_INITIALIZE => 'onRegistrationInitialize',
            FOSUserEvents::REGISTRATION_SUCCESS => 'onRegistrationSuccess',
        );
    }

    public function onRegistrationInitialize(UserEvent $event) {
        $this->user = $event->getUser();
    }
    
    public function onRegistrationSuccess() {
        $this->user->addRole($this->em->getRepository('SonataUserBundle:Role')->findOneByName('ROLE_USER'));
    }
}