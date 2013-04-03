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

    public function __construct(EntityManager $em, UserManager $userManager, UrlGeneratorInterface $router) {
        $this->em = $em;
        $this->userManager = $userManager;
        $this->router = $router;
    }

    public static function getSubscribedEvents() {
        return array(FOSUserEvents::REGISTRATION_INITIALIZE => 'onRegistrationInitialize');
    }

    public function onRegistrationInitialize(UserEvent $event) {
        $event->getUser()->addRole($this->em->getRepository('SonataUserBundle:Role')->findByName('ROLE_USER'));
    }
}