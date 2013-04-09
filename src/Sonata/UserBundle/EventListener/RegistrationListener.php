<?php

namespace Sonata\UserBundle\EventListener;

use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\UserEvent;
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
    private $router;

    public function __construct(EntityManager $em, UrlGeneratorInterface $router) {
        $this->em = $em;
        $this->router = $router;
    }

    public static function getSubscribedEvents() {
        return array(
            FOSUserEvents::REGISTRATION_INITIALIZE => 'onRegistrationInitialize',
        );
    }

    public function onRegistrationInitialize(UserEvent $event) {
        $event->getUser()->addRole($this->em->getRepository('SonataUserBundle:Role')->findOneByName('ROLE_USER'));
    }

}