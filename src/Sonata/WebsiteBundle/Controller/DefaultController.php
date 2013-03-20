<?php

namespace Sonata\WebsiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller {

    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction() {
        return array();
    }

    /**
     * @Route("/search")
     * @Template("SonataWebsite:Search:results")
     */
    public function searchAction() {
        $searchTerm = $this->getRequest()->query->get('searchTerm');

        if (isset($searchTerm)) {
            return array();
        } else {
            return $this->redirect($this->generateUrl('sonata_website'));
        }
    }
}
