<?php

namespace Sonata\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
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
     * @Route("/create/{userID}/{userName}", requirements={"userID" = "\d+"}, defaults={"userName" = null}, name="insurance_create")
     * @Method("POST")
     * @Template("SonataUserBundle:Insurance:new.html.twig")
     */
    public function createAction(Request $request, $userID, $userName) {
        $insurance = new Insurance();
        $form = $this->createForm(new InsuranceType(), $insurance);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            // Add Insurance to User
            $user = $em->getRepository('SonataUserBundle:User')->find($userID);
            $user->setInsuranceInfo($insurance);
            $insurance->setPatient($user);

            $em->persist($insurance);
            $em->persist($user);
            $em->flush();

            return $this->redirect($this->generateUrl('insurance_show', array('userID' => $userID, 'userName' => $userName, 'id' => $insurance->getId())));
        }

        return array(
            'entity' => $insurance,
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Insurance entity.
     *
     * @Route("/new/{userID}/{userName}", requirements={"userID" = "\d+"}, defaults={"userName" = null}, name="insurance_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction($userID, $userName) {
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
     * @Route("/show/{id}/{userID}/{userName}", requirements={"id" = "\d+", "userID" = "\d+"}, defaults={"userName" = null}, name="insurance_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id, $userID, $userName) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SonataUserBundle:Insurance')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Insurance entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'userID' => $userID,
            'userName' => $userName,
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Insurance entity.
     *
     * @Route("/edit/{id}/{userID}/{userName}", requirements={"userID" = "\d+", "id" = "\d+"}, defaults={"userName" = null}, name="insurance_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id, $userID, $userName) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SonataUserBundle:Insurance')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Insurance entity.');
        }

        $editForm = $this->createForm(new InsuranceType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'userID' => $userID,
            'userName' => $userName,
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Insurance entity.
     *
     * @Route("/update/{id}/{userID}/{userName}", requirements={"userID" = "\d+", "id" = "\d+"}, defaults={"userName" = null}, name="insurance_update")
     * @Method("PUT")
     * @Template("SonataUserBundle:Insurance:edit.html.twig")
     */
    public function updateAction(Request $request, $id, $userID, $userName) {
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

            return $this->redirect($this->generateUrl('insurance_edit', array('id' => $id, 'userID' => $userID, 'userName' => $userName)));
        }

        return array(
            'userID' => $userID,
            'userName' => $userName,
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

            $userID = $entity->getPatient()->getId();
            
            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Insurance entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        // Grab the currently Logged In User to determine where to send
        $currentUser = $this->get('security.context')->getToken()->getUser();
        
        if ($currentUser->hasRoleByName('ROLE_PATIENT')) {
            // If the Logged In User is a Patient then send to Patient Splash Page
            $url = $this->container->get('router')->generate('user_patient_splash');
        } elseif (isset($userID)) {
            // If the User ID is specified (Which is should) send to Patient Info Page
            $url = $this->container->get('router')->generate('user_show', array('id' => $userID));
        } elseif ($currentUser->hasRoleByName('ROLE_ADMIN')) {
            // If the Logged In user is an Office Admin then send to Admin Splash Page
            $url = $this->container->get('router')->generate('user_admin_splash');
        } else {
            // If the User cannot the determined then return to homepage
            $url = $this->container->get('router')->generate('homepage');
        }

        return new RedirectResponse($url);
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
