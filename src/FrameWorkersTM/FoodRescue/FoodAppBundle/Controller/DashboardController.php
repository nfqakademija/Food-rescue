<?php
// src/FrameWorkersTm/FoodRescue/FoodAppBundle/Controller/DashboardController.php

namespace FrameWorkersTM\FoodRescue\FoodAppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class DashboardController extends Controller
{
    public function indexAction(Request $request)
    {
        $session = $request->getSession();
        $array['logged']= $session->get('logged');
        return $this->render('FrameWorkersTMFoodRescueFoodAppBundle:Dashboard:index.html.twig',$array);
    }
}