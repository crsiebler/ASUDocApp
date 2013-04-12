<?php

namespace Sonata\WebsiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller {

    /**
     * @Route("/", name="homepage")
     * @Template()
     */
    public function indexAction() {
        return array();
    }

    /**
     * @Route("/search", name="search")
     * @Method({"POST"})
     * @Template()
     */
    public function searchAction() {
        $securityContext = $this->container->get('security.context');
        if ($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED') || $securityContext->isGranted('IS_AUTHENTICATED_FULLY')) {
            // authenticated REMEMBERED, FULLY will imply REMEMBERED (NON anonymous)
            // Use deep search because parameter is in a multidimensional array
            $searchTerm = $this->getRequest()->get('sonata_websitebundle_searchtype[searchTerm]', null, true);

            //@todo add user logged in check
            //@todo create userRepository to search for patient names and/or doctor, nurse, admin, EMT
            
            return array('searchTerm' => $searchTerm);
        } else {
            $url = $this->container->get('router')->generate('search_error', array('type' => "Login Error: User must login to use this feature"));
            $response = new RedirectResponse($url);
            $searchTerm = 'Please login to use this feature';
            
            return $response;
        }
    }
    
    /**
     * @Route("/search/error/{type}", defaults={"type" = null}, name="search_error")
     * @Method({"GET"})
     * @Template()
     */
    public function searchErrorAction($type) {
        if (isset($type) && is_string($type)) {
            return array('error' => $type);
        }
        
        return array('error' => null);
    }
}
