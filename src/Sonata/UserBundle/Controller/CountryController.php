<?php

namespace Sonata\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class CountryController extends Controller {

    /**
     * @Route("/state", name="countryurl")
     */
    public function stateChangeAction() {
        $request = $this->getRequest();
        $countryID = $request->request->get('country');

        if (is_numeric($countryID)) {
            $em = $this->getDoctrine()->getManager();
            $country = $em->find('GhostArmorUserBundle:Country', $countryID);


            $state = new \GhostArmor\UserBundle\Entity\State();

            $jsonArray = array();

            foreach ($country->getStates() as $state) {
                $jsonArray[] = array(
                    'id' => $state->getId(),
                    'name' => $state->getName(),
                );
            }

            $response = new Response(json_encode($jsonArray));
        } else {
            $response = new Response(json_encode(array('error' => "Country must be numeric")));
        }

        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

}