<?php

namespace Sonata\HealthBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sonata\HealthBundle\Entity\Allergy;
use Sonata\HealthBundle\Form\AllergyType;

/**
 * Allergy controller.
 *
 * @Route("/allergy")
 */
class AllergyController extends Controller {

    /**
     * Lists all Allergy entities.
     *
     * @Route("/", name="allergy")
     * @Method("GET")
     * @Template()
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SonataHealthBundle:Allergy')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new Allergy entity.
     *
     * @Route("/", name="allergy_create")
     * @Method("POST")
     * @Template("SonataHealthBundle:Allergy:new.html.twig")
     */
    public function createAction(Request $request) {
        $entity = new Allergy();
        $form = $this->createForm(new AllergyType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('allergy_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Allergy entity.
     *
     * @Route("/new", name="allergy_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction() {
        $entity = new Allergy();
        $form = $this->createForm(new AllergyType(), $entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a Allergy entity.
     *
     * @Route("/{id}", name="allergy_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SonataHealthBundle:Allergy')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Allergy entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Allergy entity.
     *
     * @Route("/{id}/edit", name="allergy_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SonataHealthBundle:Allergy')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Allergy entity.');
        }

        $editForm = $this->createForm(new AllergyType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Allergy entity.
     *
     * @Route("/{id}", name="allergy_update")
     * @Method("PUT")
     * @Template("SonataHealthBundle:Allergy:edit.html.twig")
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SonataHealthBundle:Allergy')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Allergy entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new AllergyType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('allergy_edit', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Allergy entity.
     *
     * @Route("/{id}", name="allergy_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SonataHealthBundle:Allergy')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Allergy entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('allergy'));
    }

    /**
     * Creates a form to delete a Allergy entity by id.
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
