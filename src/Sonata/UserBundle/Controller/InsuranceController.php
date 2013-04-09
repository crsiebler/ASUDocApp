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
class InsuranceController extends Controller
{

    /**
     * Lists all Insurance entities.
     *
     * @Route("/", name="insurance")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SonataUserBundle:Insurance')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Insurance entity.
     *
     * @Route("/", name="insurance_create")
     * @Method("POST")
     * @Template("SonataUserBundle:Insurance:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Insurance();
        $form = $this->createForm(new InsuranceType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('insurance_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Insurance entity.
     *
     * @Route("/new", name="insurance_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Insurance();
        $form   = $this->createForm(new InsuranceType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Insurance entity.
     *
     * @Route("/{id}", name="insurance_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SonataUserBundle:Insurance')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Insurance entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Insurance entity.
     *
     * @Route("/{id}/edit", name="insurance_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SonataUserBundle:Insurance')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Insurance entity.');
        }

        $editForm = $this->createForm(new InsuranceType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Insurance entity.
     *
     * @Route("/{id}", name="insurance_update")
     * @Method("PUT")
     * @Template("SonataUserBundle:Insurance:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
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
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Insurance entity.
     *
     * @Route("/{id}", name="insurance_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
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
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
