<?php
// src/FrameWorkersTm/FoodRescue/FoodAppBundle/Controller/DefaultController.php

namespace FrameWorkersTM\FoodRescue\FoodAppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class DefaultController extends Controller
{
    /* deprecated
    public function indexAction($name)
    {
        return $this->render('FrameWorkersTMFoodRescueFoodAppBundle:Default:index.html.twig', array('name' => $name));
    }
    */

    public function indexAction(Request $request)
    {
        $session = $request->getSession();
        $array['logged']= $session->get('logged');
        return $this->render('FrameWorkersTMFoodRescueFoodAppBundle:Default:index.html.twig',$array);
    }
}
