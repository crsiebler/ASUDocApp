<?php

namespace Sonata\AppointmentBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sonata\AppointmentBundle\Entity\Appointment;
use Sonata\AppointmentBundle\Form\AppointmentType;

/**
 * Appointment controller.
 *
 * @Route("/appointment")
 */
class AppointmentController extends Controller {

    /**
     * Lists all Appointment entities.
     *
     * @Route("/", name="appointment")
     * @Method("GET")
     * @Template()
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SonataAppointmentBundle:Appointment')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new Appointment entity.
     *
     * @Route("/", name="appointment_create")
     * @Method("POST")
     * @Template("SonataAppointmentBundle:Appointment:new.html.twig")
     */
    public function createAction(Request $request) {
        $entity = new Appointment();
        $form = $this->createForm(new AppointmentType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('appointment_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Appointment entity.
     *
     * @Route("/new", name="appointment_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction() {
        $entity = new Appointment();
        $form = $this->createForm(new AppointmentType(), $entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a Appointment entity.
     *
     * @Route("/{id}", name="appointment_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SonataAppointmentBundle:Appointment')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Appointment entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Appointment entity.
     *
     * @Route("/{id}/edit", name="appointment_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SonataAppointmentBundle:Appointment')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Appointment entity.');
        }

        $editForm = $this->createForm(new AppointmentType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Appointment entity.
     *
     * @Route("/{id}", name="appointment_update")
     * @Method("PUT")
     * @Template("SonataAppointmentBundle:Appointment:edit.html.twig")
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SonataAppointmentBundle:Appointment')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Appointment entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new AppointmentType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('appointment_edit', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Appointment entity.
     *  
     * @Route("/{id}", name="appointment_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SonataAppointmentBundle:Appointment')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Appointment entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('appointment'));
    }

    /**
     * Creates a form to delete a Appointment entity by id.
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
    
    /**
     * @Route("/bloodGlucose/new/{userID}/{userName}", requirements={"userID" = "\d+"}, defaults={"userName" = null}, name="blood_glucose_new")
     * @Method({"GET", "POST"})
     * @Template()
     */
    private function newGlucoseAction($userID, $userName) {
        $request = $this->getRequest();
        
        $appointment = new Appointment();
        $form = $this->createForm(new GlucoseType(), $appointment);
        
        if ("POST" === $request->getMethod()) {
            $form->bind($request);
            
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();

                $user = $em->getRepository('SonataUserBundle:User')->findOneById($userID);

                if (!$user) {
                    throw $this->createNotFoundException('Unable to find User entity.');
                }
                
                $user->getAppointments->add($appointment);
                $appointment->setPatient($user);
                
                $em->persist($appointment);
                $em->persist($user);
                $em->flush();
                
                return $this->redirect($this->generateUrl('user_splash'));
            }
        }
        
        return array(
            'userName' => $userName,
            'userID' => $userID,
            'entity' => $appointment,
            'form' => $form->createView(),
        );
    }
    
    /**
     * @Route("/bloodGlucose/show/{userID}/{userName}", requirements={"userID" = "\d+"}, defaults={"userName" = null}, name="blood_glucose_show")
     * @Method("GET")
     * @Template()
     */
    private function showGlucoseAction($userID, $userName) {
        
    }
    
    /**
     * @Route("/weight/new/{userID}/{userName}", requirements={"userID" = "\d+"}, defaults={"userName" = null}, name="weight_new")
     * @Method({"GET", "POST"})
     * @Template()
     */
    private function newWeightAction($userID, $userName) {
        
    }
    
    /**
     * @Route("/weight/show/{userID}/{userName}", requirements={"userID" = "\d+"}, defaults={"userName" = null}, name="weight_show")
     * @Method({"GET", "POST"})
     * @Template()
     */
    private function showWeightAction($userID, $userName) {
        
    }
    
    /**
     * @Route("/bloodPressure/new/{userID}/{userName}", requirements={"userID" = "\d+"}, defaults={"userName" = null}, name="blood_pressure_new")
     * @Method({"GET", "POST"})
     * @Template()
     */
    private function newPressureAction($userID, $userName) {
        
    }
    
    /**
     * @Route("/bloodPressure/show/{userID}/{userName}", requirements={"userID" = "\d+"}, defaults={"userName" = null}, name="blood_pressure_show")
     * @Method({"GET", "POST"})
     * @Template()
     */
    private function showPressureAction($userID, $userName) {
        
    }

}
