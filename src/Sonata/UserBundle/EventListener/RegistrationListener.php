<?php

namespace Sonata\UserBundle\EventListener;

use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\UserEvent;
use FOS\UserBundle\Event\FilterUserResponseEvent;
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
            FOSUserEvents::REGISTRATION_COMPLETED => 'onRegistrationCompleted',
        );
    }

    public function onRegistrationInitialize(UserEvent $event) {
        $event->getUser()->addRole($this->em->getRepository('SonataUserBundle:Role')->findOneByName('ROLE_USER'));
    }

    public function onRegistrationCompleted(FilterUserResponseEvent $event) {
        $url = $this->router->generate('sonata_user_registration_confirmed');
        $response = $event->getResponse();
        $response = new RedirectResponse($url);
    }
    
}