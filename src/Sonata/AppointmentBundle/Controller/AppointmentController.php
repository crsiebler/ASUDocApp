<?php

namespace Sonata\AppointmentBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sonata\AppointmentBundle\Entity\Appointment;
use Sonata\AppointmentBundle\Entity\Note;
use Sonata\HealthBundle\Entity\BloodPressure;
use Sonata\AppointmentBundle\Form\AppointmentType;
use Sonata\AppointmentBundle\Form\PressureType;
use Sonata\AppointmentBundle\Form\GlucoseType;
use Sonata\AppointmentBundle\Form\WeightType;
use Ob\HighchartsBundle\Highcharts\Highchart;

/**
 * Appointment controller.
 *
 * @Route("/appointment")
 */
class AppointmentController extends Controller {

    /**
     * Creates a new Appointment entity.
     *
     * @Route("/create/{patientID}/{patientName}", requirements={"patientID" = "\d+"}, defaults={"patientName" = null}, name="appointment_create")
     * @Method({"GET", "POST"})
     * @Template("SonataAppointmentBundle:Appointment:new.html.twig")
     */
    public function createAction(Request $request, $patientID, $patientName) {
        $inOffice = true;
        
        $note = new Note($this->get('security.context')->getToken()->getUser());
        $appointment = new Appointment($inOffice);
        $bpReading = new BloodPressure();
        
        $appointment->setNote($note);
        $appointment->setBloodPressure($bpReading);
        
        $form = $this->createForm(new AppointmentType($this->get('security.context')), $appointment);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            $patient = $em->getRepository('SonataUserBundle:User')->findOneById($patientID);

            $appointment->setPatient($patient);
            $appointment->setInOffice(true);
            
            $em->persist($appointment);
            $em->persist($note);
            $em->persist($bpReading);
            $em->flush();

            return $this->redirect($this->generateUrl('appointment_show', array('id' => $appointment->getId(), 'patientID' => $patientID, 'patientName' => $patientName)));
        }

        return array(
            'entity' => $appointment,
            'form' => $form->createView(),
            'patientID' => $patientID,
            'patientName' => $patientName,
        );
    }

    /**
     * Displays a form to create a new Appointment entity.
     *
     * @Route("/new/{patientID}/{patientName}", requirements={"patientID" = "\d+"}, defaults={"patientName" = null}, name="appointment_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction($patientID, $patientName) {
        $inOffice = true;
        
        $appointment = new Appointment($inOffice);
        $note = new Note($this->get('security.context')->getToken()->getUser());
        
        $appointment->setNote($note);
        
        $form = $this->createForm(new AppointmentType($this->get('security.context')), $appointment);
        
        $em = $this->getDoctrine()->getManager();
        
        $patient = $em->getRepository('SonataUserBundle:User')->findOneById($patientID);
        
        $appointment->setPatient($patient);

        return array(
            'entity' => $appointment,
            'form' => $form->createView(),
            'patientID' => $patientID,
            'patientName' => $patientName,
        );
    }

    /**
     * Finds and displays a Appointment entity.
     *
     * @Route("/show/{id}/{patientID}/{patientName}", requirements={"patientID" = "\d+"}, defaults={"patientName" = null}, name="appointment_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id, $patientID, $patientName) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SonataAppointmentBundle:Appointment')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Appointment entity.');
        }

        return array(
            'entity' => $entity,
            'patientID' => $patientID,
            'patientName' => $patientName,
        );
    }

    /**
     * Displays a form to edit an existing Appointment entity.
     *
     * @Route("/edit/{id}/{patientID}/{patientName}", requirements={"patientID" = "\d+"}, defaults={"patientName" = null}, name="appointment_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id, $patientID, $patientName) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SonataAppointmentBundle:Appointment')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Appointment entity.');
        }

        $editForm = $this->createForm(new AppointmentType($this->get('security.context')), $entity);

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'patientID' => $patientID,
            'patientName' => $patientName,
        );
    }

    /**
     * Edits an existing Appointment entity.
     *
     * @Route("/update/{id}/{patientID}/{patientName}", requirements={"patientID" = "\d+"}, defaults={"patientName" = null}, name="appointment_update")
     * @Method("PUT")
     * @Template("SonataAppointmentBundle:Appointment:edit.html.twig")
     */
    public function updateAction(Request $request, $id, $patientID, $patientName) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SonataAppointmentBundle:Appointment')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Appointment entity.');
        }

        $editForm = $this->createForm(new AppointmentType($this->get('security.context')), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('appointment_edit', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'patientID' => $patientID,
            'patientName' => $patientName,
        );
    }

    /**
     * @Route("/bloodGlucose/new/{userID}/{userName}", requirements={"userID" = "\d+"}, defaults={"userName" = null}, name="blood_glucose_new")
     * @Method({"GET", "POST"})
     * @Template("SonataAppointmentBundle:Appointment:newGlucose.html.twig")
     */
    public function newGlucoseAction($userID, $userName) {
        $request = $this->getRequest();
        
        $inOffice = false;
        
        $appointment = new Appointment($inOffice);
        $form = $this->createForm(new GlucoseType(), $appointment);
        
        if ("POST" === $request->getMethod()) {
            $form->bind($request);
            
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();

                $user = $em->getRepository('SonataUserBundle:User')->findOneById($userID);

                if (!$user) {
                    throw $this->createNotFoundException('Unable to find User entity.');
                }
                
                $user->getAppointments()->add($appointment);
                $appointment->setPatient($user);
                $appointment->setInOffice(false);
                
                $em->persist($appointment);
                $em->persist($user);
                $em->flush();
                
                return $this->redirect($this->generateUrl('user_splash'));
            }
        }
        
        return array(
            'patientName' => $userName,
            'patientID' => $userID,
            'entity' => $appointment,
            'form' => $form->createView(),
        );
    }
    
    /**
     * @Route("/bloodGlucose/show/{userID}/{userName}", requirements={"userID" = "\d+"}, defaults={"userName" = null}, name="blood_glucose_show")
     * @Method("GET")
     * @Template("SonataAppointmentBundle:Appointment:graph.html.twig")
     */
    public function showGlucoseAction($userID, $userName) {
        $em = $this->getDoctrine()->getManager();
        
        $readings = $em->getRepository('SonataAppointmentBundle:Appointment')->getGlucoseReadings($userID);

        if (!empty($readings)) {
            foreach ($readings as $reading) {
                $dateOf[] = $reading['dateOf'];
                $glucose[] = intval($reading['glucose']);
            }
            
            $series = array(
                array("name" => "Glucose Level", "data" => $glucose)
            );

            $ob = new Highchart();
            $ob->chart->renderTo('linechart');
            $ob->title->text('Blood Glucose Levels');
            $ob->xAxis->title(array('text' => "Date Range"));
            $ob->subtitle->text($userName);
            $ob->xAxis->categories($dateOf);
            $ob->yAxis->title(array('text' => "Glucose Level (mg/dl)"));
            $ob->yAxis->plotlines(array('value' => 0, 'width' => 1, 'color' => "#808080"));
            $ob->legend->layout('vertical');
            $ob->legend->align('right');
            $ob->legend->verticleAlign('top');
            $ob->legend->x(0);
            $ob->legend->y(-200);
            $ob->legend->borderWidth(0);
            $ob->series($series);

            return array(
                'chart' => $ob,
                'patientID' => $userID,
                'patientName' => $userName,
            );
        } else {
            return $this->redirect($this->generateUrl('search_error'));
        }
    }
    
    /**
     * @Route("/weight/new/{userID}/{userName}", requirements={"userID" = "\d+"}, defaults={"userName" = null}, name="weight_new")
     * @Method({"GET", "POST"})
     * @Template("SonataAppointmentBundle:Appointment:newWeight.html.twig")
     */
    public function newWeightAction($userID, $userName) {
        $request = $this->getRequest();
        
        $inOffice = false;
        
        $appointment = new Appointment($inOffice);
        $form = $this->createForm(new WeightType(), $appointment);
        
        if ("POST" === $request->getMethod()) {
            $form->bind($request);
            
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();

                $user = $em->getRepository('SonataUserBundle:User')->findOneById($userID);

                if (!$user) {
                    throw $this->createNotFoundException('Unable to find User entity.');
                }
                
                $user->getAppointments()->add($appointment);
                $appointment->setPatient($user);
                $appointment->setInOffice(false);
                
                $em->persist($appointment);
                $em->persist($user);
                $em->flush();
                
                return $this->redirect($this->generateUrl('user_splash'));
            }
        }
        
        return array(
            'patientName' => $userName,
            'patientID' => $userID,
            'entity' => $appointment,
            'form' => $form->createView(),
        );
    }
    
    /**
     * @Route("/weight/show/{userID}/{userName}", requirements={"userID" = "\d+"}, defaults={"userName" = null}, name="weight_show")
     * @Method({"GET", "POST"})
     * @Template("SonataAppointmentBundle:Appointment:graph.html.twig")
     */
    public function showWeightAction($userID, $userName) {
        $em = $this->getDoctrine()->getManager();
        
        $readings = $em->getRepository('SonataAppointmentBundle:Appointment')->getWeightReadings($userID);

        if (!empty($readings)) {
            foreach ($readings as $reading) {
                $dateOf[] = $reading['dateOf'];
                $weight[] = intval($reading['weight']);
            }
            
            $series = array(
                array("name" => "weight", "data" => $weight),
            );

            $ob = new Highchart();
            $ob->chart->renderTo('linechart');
            $ob->title->text('Weight');
            $ob->xAxis->title(array('text' => "Date Range"));
            $ob->subtitle->text($userName);
            $ob->xAxis->categories($dateOf);
            $ob->yAxis->title(array('text' => "Weight (kg)"));
            $ob->yAxis->plotlines(array('value' => 0, 'width' => 1, 'color' => "#808080"));
            $ob->legend->layout('vertical');
            $ob->legend->align('right');
            $ob->legend->verticleAlign('top');
            $ob->legend->x(0);
            $ob->legend->y(-200);
            $ob->legend->borderWidth(0);
            $ob->series($series);

            return array(
                'chart' => $ob,
                'patientID' => $userID,
                'patientName' => $userName,
            );
        } else {
            return $this->redirect($this->generateUrl('search_error'));
        }
    }
    
    /**
     * @Route("/bloodPressure/new/{userID}/{userName}", requirements={"userID" = "\d+"}, defaults={"userName" = null}, name="blood_pressure_new")
     * @Method({"GET", "POST"})
     * @Template("SonataAppointmentBundle:Appointment:newPressure.html.twig"
)     */
    public function newPressureAction($userID, $userName) {
        $request = $this->getRequest();
        
        $inOffice = false;
        
        $appointment = new Appointment($inOffice);
        $form = $this->createForm(new PressureType(), $appointment);
        
        if ("POST" === $request->getMethod()) {
            $form->bind($request);
            
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();

                $user = $em->getRepository('SonataUserBundle:User')->findOneById($userID);

                if (!$user) {
                    throw $this->createNotFoundException('Unable to find User entity.');
                }
                
                $user->getAppointments()->add($appointment);
                $appointment->setPatient($user);
                $appointment->setInOffice(false);
                
                $em->persist($appointment);
                $em->persist($user);
                $em->flush();
                
                return $this->redirect($this->generateUrl('user_splash'));
            }
        }
        
        return array(
            'patientName' => $userName,
            'patientID' => $userID,
            'entity' => $appointment,
            'form' => $form->createView(),
        );
    }
    
    /**
     * @Route("/bloodPressure/show/{userID}/{userName}", requirements={"userID" = "\d+"}, defaults={"userName" = null}, name="blood_pressure_show")
     * @Method({"GET", "POST"})
     * @Template("SonataAppointmentBundle:Appointment:graph.html.twig")
     */
    public function showPressureAction($userID, $userName) {
        $em = $this->getDoctrine()->getManager();
        
        $readings = $em->getRepository('SonataAppointmentBundle:Appointment')->getBPReadings($userID);

        if (!empty($readings)) {
            foreach ($readings as $reading) {
                $dateOf[] = $reading['dateOf'];
                $bpMax[] = intval($reading['max']);
                $bpMin[] = intval($reading['min']);
            }
            
            $series = array(
                array("name" => "systolic", "data" => $bpMax),
                array("name" => "diastolic", "data" => $bpMin)
            );

            $ob = new Highchart();
            $ob->chart->renderTo('linechart');
            $ob->title->text('Blood Pressure');
            $ob->xAxis->title(array('text' => "Date Range"));
            $ob->subtitle->text($userName);
            $ob->xAxis->categories($dateOf);
            $ob->yAxis->title(array('text' => "(mmHg)"));
            $ob->yAxis->plotlines(array('value' => 0, 'width' => 1, 'color' => "#808080"));
            $ob->legend->layout('vertical');
            $ob->legend->align('right');
            $ob->legend->verticleAlign('top');
            $ob->legend->x(0);
            $ob->legend->y(-200);
            $ob->legend->borderWidth(0);
            $ob->series($series);

            return array(
                'chart' => $ob,
                'patientID' => $userID,
                'patientName' => $userName,
            );
        } else {
            return $this->redirect($this->generateUrl('search_error'));
        }
    }

}
