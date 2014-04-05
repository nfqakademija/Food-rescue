<?php
// src/FrameWorkersTm/FoodRescue/FoodAppBundle/Controller/DefaultController.php

namespace FrameWorkersTM\FoodRescue\FoodAppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /* deprecated
    public function indexAction($name)
    {
        return $this->render('FrameWorkersTMFoodRescueFoodAppBundle:Default:index.html.twig', array('name' => $name));
    }
    */

    public function indexAction()
    {
        return $this->render('FrameWorkersTMFoodRescueFoodAppBundle:Default:index.html.twig');
    }
}
