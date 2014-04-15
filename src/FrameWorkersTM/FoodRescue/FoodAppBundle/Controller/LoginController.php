<?php
// src/FrameWorkersTm/FoodRescue/FoodAppBundle/Controller/LoginController.php

namespace FrameWorkersTM\FoodRescue\FoodAppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FrameWorkersTM\FoodRescue\FoodAppBundle\Entity\Task;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class LoginController extends Controller
{

    public function indexAction(Request $request)
    {
        $session = $request->getSession();
        $username = $session->get('logged');

        // build Prisijungimo form
        $formBuilderOne = $this->container
            ->get('form.factory')
            ->createNamedBuilder('formOne', 'form', NULL, array('validation_groups' => array()))
            ->add('loginName', 'text', array('label'  => 'Slapyvardis'))
            ->add('password', 'password', array('label'  => 'Slaptažodis'))
            ->add('save', 'submit', array('label'  => 'Prisijungti'));

        // get form from form builder
        $formOne = $formBuilderOne
            ->getForm()
            ->handleRequest($request);

        // build Registracijos form
        $formBuilderTwo = $this->container
            ->get('form.factory')
            ->createNamedBuilder('formTwo', 'form', NULL, array('validation_groups' => array()))
            ->add('loginName', 'text', array('label'  => 'Slapyvardis'))
            ->add('email', 'email', array('label'  => 'El. paštas'))
            ->add('password', 'password', array('label'  => 'Slaptažodis'))
            ->add('password2', 'password', array('label'  => 'Pakartoti slaptažodį'))
            ->add('save', 'submit', array('label'  => 'Registruotis'));

        // get form from form builder
        $formTwo = $formBuilderTwo
            ->getForm()
            ->handleRequest($request);

        // wait for valid form input
        if ($formOne->isValid())
        {
            // perform some action, such as saving the task to the database
            $session->set('logged', $formOne->get('loginName')->getData());
            return $this->redirect($this->generateUrl('frame_workers_tm_food_rescue_food_app_my_products'));
        }

        // wait for valid form input
        if ($formTwo->isValid())
        {
            // perform some action, such as saving the task to the database
            $session->set('logged', $formTwo->get('loginName')->getData());
            return $this->redirect($this->generateUrl('frame_workers_tm_food_rescue_food_app_my_products'));
        }

        return $this->render('FrameWorkersTMFoodRescueFoodAppBundle:Login:index.html.twig', array(
            'form' => $formOne->createView(),
            'form2' => $formTwo->createView(),
            'logged'=> $username,
        ));

    }

    public function logoutAction(Request $request)
    {
        $session = $request->getSession();
        $session->remove('logged');
        return $this->redirect($this->generateUrl('frame_workers_tm_food_rescue_food_app_homepage'));
    }


}