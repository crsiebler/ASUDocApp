<?php

namespace Sonata\WebsiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
        // Use deep search because parameter is in a multidimensional array
        $searchTerm = $this->getRequest()->get('sonata_websitebundle_searchtype[searchTerm]', null, true);

        //@todo add user logged in check
        //@todo create userRepository to search for patient names and/or doctor, nurse, admin, EMT

        return array('searchTerm' => $searchTerm);
    }
}
