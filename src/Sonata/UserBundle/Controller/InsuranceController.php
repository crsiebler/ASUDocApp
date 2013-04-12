<?php

namespace Sonata\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sonata\UserBundle\Entity\Insurance;
use Sonata\UserBundle\Form\InsuranceType;

/**
 * Insurance controller.
 *
 * @Route("/insurance")
 */
class InsuranceController extends Controller {

    /**
     * Creates a new Insurance entity.
     *
     * @Route("/create/{userID}", requirements={"userID" = "\d+"}, name="insurance_create")
     * @Method("POST")
     * @Template("SonataUserBundle:Insurance:new.html.twig")
     */
    public function createAction($userID, Request $request) {
        $insurance = new Insurance();
        $form = $this->createForm(new InsuranceType(), $insurance);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            // Add Insurance to User
            $user = $em->getRepository('SonataUserBundle:User')->find($userID);
            $user->setInsuranceInfo($insurance);
            
            $em->persist($insurance);
            $em->persist($user);
            $em->flush();

            return $this->redirect($this->generateUrl('insurance_show', array('userID' => $userID, 'id' => $insurance->getId())));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Insurance entity.
     *
     * @Route("/new/{userName}/{userID}", requirements={"userID" = "\d+"}, name="insurance_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction($userName, $userID) {
        $entity = new Insurance();
        $form = $this->createForm(new InsuranceType(), $entity);

        return array(
            'userName' => $userName,
            'userID' => $userID,
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a Insurance entity.
     *
     * @Route("/show/{userID}/{id}", name="insurance_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($userID, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SonataUserBundle:User')->find($userID)->getInsuranceInfo();

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Insurance entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Insurance entity.
     *
     * @Route("/edit/{userID}/{id}", name="insurance_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($userID, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SonataUserBundle:User')->find($userID)->getInsuranceInfo();

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Insurance entity.');
        }

        $editForm = $this->createForm(new InsuranceType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Insurance entity.
     *
     * @Route("/{id}", defaults={"userID" = 0}, name="insurance_update")
     * @Method("PUT")
     * @Template("SonataUserBundle:Insurance:edit.html.twig")
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SonataUserBundle:Insurance')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Insurance entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new InsuranceType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('insurance_edit', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Insurance entity.
     *
     * @Route("/{id}", name="insurance_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SonataUserBundle:Insurance')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Insurance entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('insurance'));
    }

    /**
     * Creates a form to delete a Insurance entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder(array('id' => $id))
                        ->add('id', 'hidden')
                        ->getForm();
    }
}
