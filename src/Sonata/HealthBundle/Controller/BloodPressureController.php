<?php

namespace Sonata\HealthBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sonata\HealthBundle\Entity\BloodPressure;
use Sonata\HealthBundle\Form\BloodPressureType;

/**
 * BloodPressure controller.
 *
 * @Route("/bloodpressure")
 */
class BloodPressureController extends Controller {

    /**
     * Lists all BloodPressure entities.
     *
     * @Route("/", name="bloodpressure")
     * @Method("GET")
     * @Template()
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SonataHealthBundle:BloodPressure')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new BloodPressure entity.
     *
     * @Route("/", name="bloodpressure_create")
     * @Method("POST")
     * @Template("SonataHealthBundle:BloodPressure:new.html.twig")
     */
    public function createAction(Request $request) {
        $entity = new BloodPressure();
        $form = $this->createForm(new BloodPressureType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('bloodpressure_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new BloodPressure entity.
     *
     * @Route("/new", name="bloodpressure_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction() {
        $entity = new BloodPressure();
        $form = $this->createForm(new BloodPressureType(), $entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a BloodPressure entity.
     *
     * @Route("/{id}", name="bloodpressure_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SonataHealthBundle:BloodPressure')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find BloodPressure entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing BloodPressure entity.
     *
     * @Route("/{id}/edit", name="bloodpressure_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SonataHealthBundle:BloodPressure')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find BloodPressure entity.');
        }

        $editForm = $this->createForm(new BloodPressureType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing BloodPressure entity.
     *
     * @Route("/{id}", name="bloodpressure_update")
     * @Method("PUT")
     * @Template("SonataHealthBundle:BloodPressure:edit.html.twig")
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SonataHealthBundle:BloodPressure')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find BloodPressure entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new BloodPressureType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('bloodpressure_edit', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a BloodPressure entity.
     *
     * @Route("/{id}", name="bloodpressure_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SonataHealthBundle:BloodPressure')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find BloodPressure entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('bloodpressure'));
    }

    /**
     * Creates a form to delete a BloodPressure entity by id.
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
