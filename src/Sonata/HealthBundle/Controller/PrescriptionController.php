<?php

namespace Sonata\HealthBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
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
     * Lists all Prescription entities.
     *
     * @Route("/", name="prescription")
     * @Method("GET")
     * @Template()
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SonataHealthBundle:Prescription')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new Prescription entity.
     *
     * @Route("/", name="prescription_create")
     * @Method("POST")
     * @Template("SonataHealthBundle:Prescription:new.html.twig")
     */
    public function createAction(Request $request) {
        $entity = new Prescription();
        $form = $this->createForm(new PrescriptionType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('prescription_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Prescription entity.
     *
     * @Route("/new", name="prescription_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction() {
        $entity = new Prescription();
        $form = $this->createForm(new PrescriptionType(), $entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a Prescription entity.
     *
     * @Route("/{id}", name="prescription_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SonataHealthBundle:Prescription')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Prescription entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Prescription entity.
     *
     * @Route("/{id}/edit", name="prescription_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SonataHealthBundle:Prescription')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Prescription entity.');
        }

        $editForm = $this->createForm(new PrescriptionType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Prescription entity.
     *
     * @Route("/{id}", name="prescription_update")
     * @Method("PUT")
     * @Template("SonataHealthBundle:Prescription:edit.html.twig")
     */
    public function updateAction(Request $request, $id) {
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

            return $this->redirect($this->generateUrl('prescription_edit', array('id' => $id)));
        }

        return array(
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

        return $this->redirect($this->generateUrl('prescription'));
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
