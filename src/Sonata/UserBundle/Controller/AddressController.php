<?php

namespace Sonata\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sonata\UserBundle\Entity\Address;
use Sonata\UserBundle\Form\AddressType;

/**
 * Address controller.
 *
 * @Route("/address")
 */
class AddressController extends Controller {

    /**
     * Creates a new Address entity.
     *
     * @Route("/create/{userID}/{userName}", requirements={"userID" = "\d+"}, defaults={"userName" = null}, name="address_create")
     * @Method({"GET", "POST"})
     * @Template("SonataUserBundle:Address:new.html.twig")
     */
    public function createAction(Request $request, $userID, $userName) {
        $em = $this->getDoctrine()->getManager();
        
        $address = new Address();
        
        $country = $em->getRepository('SonataUserBundle:Country')->findOneByCode('US');
        
        $form = $this->createForm(new AddressType(), $address, array('prefCountry' => $country));
        $form->bind($request);

        if ($form->isValid()) {
            // Add Address to User
            $user = $em->getRepository('SonataUserBundle:User')->find($userID);
            $user->setAddress($address);
            $address->setUser($user);

            $em->persist($address);
            $em->persist($user);
            $em->flush();

            return $this->redirect($this->generateUrl('address_show', array('userID' => $userID, 'userName' => $userName, 'id' => $address->getId())));
        }

        return array(
            'userName' => $userName,
            'userID' => $userID,
            'entity' => $address,
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Address entity.
     *
     * @Route("/new/{userID}/{userName}", requirements={"userID" = "\d+"}, defaults={"userName" = null}, name="address_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction($userID, $userName) {
        $em = $this->getDoctrine()->getManager();
        
        $entity = new Address();
        
        $country = $em->getRepository('SonataUserBundle:Country')->findOneByCode('US');

        $form = $this->createForm(new AddressType(), $entity, array('prefCountry' => $country));
        
        return array(
            'userName' => $userName,
            'userID' => $userID,
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a Address entity.
     *
     * @Route("/show/{id}/{userID}/{userName}", requirements={"id" = "\d+", "userID" = "\d+"}, defaults={"userName" = null}, name="address_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id, $userID, $userName) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SonataUserBundle:Address')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Address entity.');
        }

        return array(
            'userID' => $userID,
            'userName' => $userName,
            'entity' => $entity,
        );
    }

    /**
     * Displays a form to edit an existing Address entity.
     *
     * @Route("/edit/{id}/{userID}/{userName}", requirements={"userID" = "\d+", "id" = "\d+"}, defaults={"userName" = null}, name="address_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id, $userID, $userName) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SonataUserBundle:Address')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Address entity.');
        }

        $country = $em->getRepository('SonataUserBundle:Country')->findOneByCode('US');
        
        $editForm = $this->createForm(new AddressType(), $entity, array('prefCountry' => $country));

        return array(
            'userID' => $userID,
            'userName' => $userName,
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
        );
    }

    /**
     * Edits an existing Address entity.
     *
     * @Route("/update/{id}/{userID}/{userName}", requirements={"userID" = "\d+", "id" = "\d+"}, defaults={"userName" = null}, name="address_update")
     * @Method("PUT")
     * @Template("SonataUserBundle:Address:edit.html.twig")
     */
    public function updateAction(Request $request, $id, $userID, $userName) {
        $em = $this->getDoctrine()->getManager();

        $address = $em->getRepository('SonataUserBundle:Address')->find($id);

        if (!$address) {
            throw $this->createNotFoundException('Unable to find Address entity.');
        }

        $country = $em->getRepository('SonataUserBundle:Country')->findOneByCode('US');
        
        $editForm = $this->createForm(new AddressType(), $address, array('prefCountry' => $country));
        $editForm->bind($request);

        if ($editForm->isValid()) {
            // Add Address to User
            $user = $em->getRepository('SonataUserBundle:User')->find($userID);
            $user->setAddress($address);
            $address->setUser($user);

            $em->persist($address);
            $em->persist($user);
            $em->flush();

            return $this->redirect($this->generateUrl('address_show', array('userID' => $userID, 'userName' => $userName, 'id' => $address->getId())));
        }

        return array(
            'userID' => $userID,
            'userName' => $userName,
            'entity' => $address,
            'edit_form' => $editForm->createView(),
        );
    }
}
