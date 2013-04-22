<?php

namespace Sonata\HealthBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sonata\HealthBundle\Entity\Prescription;
use Sonata\HealthBundle\Form\PrescriptionType;

/**
 * Prescription controller.
 *
 * @Route("/prescription")
 */
class PrescriptionController extends Controller {

    /**
     * Creates a new Prescription entity.
     *
     * @Route("/{userID}/{userName}", requirements={"userID" = "\d+"}, defaults={"userName" = null}, name="prescription_create")
     * @Method("POST")
     * @Template("SonataHealthBundle:Prescription:new.html.twig")
     */
    public function createAction(Request $request, $userID, $userName) {
        $prescription = new Prescription();
        $form = $this->createForm(new PrescriptionType(), $prescription);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            // Add Prescription to User
            $user = $em->getRepository('SonataUserBundle:User')->find($userID);
            $user->getAllergies()->add($prescription);
            $prescription->setPatient($user);
            
            $em->persist($prescription);
            $em->presist($user);
            $em->flush();

            return $this->redirect($this->generateUrl('prescription_show', array('userID' => $userID, 'userName' => $userName, 'id' => $prescription->getId())));
        }

        return array(
            'userName' => $userName,
            'userID' => $userID,
            'entity' => $prescription,
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Prescription entity.
     *
     * @Route("/new/{userID}/{userName}", requirements={"userID" = "\d+"}, defaults={"userName" = null}, name="prescription_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction($userName, $userID) {
        $entity = new Prescription();
        $form = $this->createForm(new PrescriptionType(), $entity);

        return array(
            'userName' => $userName,
            'userID' => $userID,
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a Prescription entity.
     *
     * @Route("/show/{userID}/{userName}", requirements={"userID" = "\d+"}, defaults={"userName" = null}, name="prescription_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($userID, $userName) {
        $em = $this->getDoctrine()->getManager();

        $prescriptions = $em->getRepository('SonataHealthBundle:Prescription')->findAll();

        if (!$prescriptions) {
            throw $this->createNotFoundException('Unable to find Prescriptions.');
        }

        foreach ($prescriptions as $prescription)
        $deleteForm = $this->createDeleteForm($prescription->getId());

        return array(
            'userID' => $userID,
            'userName' => $userName,
            'prescriptions' => $prescriptions,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Prescription entity.
     *
     * @Route("/edit/{id}/{userID}/{userName}", requirements={"userID" = "\d+", "id" = "\d+"}, defaults={"userName" = null}, name="prescription_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id, $userID, $userName) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SonataHealthBundle:Prescription')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Prescription entity.');
        }

        $editForm = $this->createForm(new PrescriptionType(), $entity);
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
     * Edits an existing Prescription entity.
     *
     * @Route("/update/{id}/{userID}/{userName}", requirements={"userID" = "\d+", "id" = "\d+"}, defaults={"userName" = null}, name="prescription_update")
     * @Method("PUT")
     * @Template("SonataHealthBundle:Prescription:edit.html.twig")
     */
    public function updateAction(Request $request, $id, $userID, $userName) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SonataHealthBundle:Prescription')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Prescription entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new PrescriptionType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('prescription_edit', array('id' => $id, 'userID' => $userID, 'userName' => $userName)));
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
     * Deletes a Prescription entity.
     *
     * @Route("/{id}", name="prescription_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SonataHealthBundle:Prescription')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Prescription entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        // Grab the currently Logged In User to determine where to send
        $currentUser = $this->get('security.context')->getToken()->getUser();
        
        if ($currentUser->hasRoleByName('ROLE_PATIENT')) {
            // If the User is logged in
            $url = $this->container->get('router')->generate('user_splash');
        } elseif ($currentUser->hasRoleByName('ROLE_USER')) {
            $url = $this->container->get('router')->generate('user_show', $entity->getPatient()->getId());
        } else {
            // If the User cannot the determined then return to homepage
            $url = $this->container->get('router')->generate('homepage');
        }

        return new RedirectResponse($url);
    }

    /**
     * Creates a form to delete a Prescription entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder(array('id' => $id))
                        ->add('id', 'hidden')
                        ->getForm()
        ;
    }

}