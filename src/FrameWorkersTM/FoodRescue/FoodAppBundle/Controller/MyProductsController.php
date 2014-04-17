<?php
// src/FrameWorkersTm/FoodRescue/FoodAppBundle/Controller/MyProductsController.php

namespace FrameWorkersTM\FoodRescue\FoodAppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class MyProductsController extends Controller
{
    public function indexAction(Request $request)
    {
        $session = $request->getSession();
        $array['logged']= $session->get('logged');
        return $this->render('FrameWorkersTMFoodRescueFoodAppBundle:MyProducts:index.html.twig',$array);
    }
}