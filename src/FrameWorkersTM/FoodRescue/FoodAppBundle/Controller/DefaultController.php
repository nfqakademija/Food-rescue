<?php
// src/FrameWorkersTm/FoodRescue/FoodAppBundle/Controller/DefaultController.php

namespace FrameWorkersTM\FoodRescue\FoodAppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        $this->get('recipeservice')->findUser($request->getSession());
        if ($this->container->get('security.context')->isGranted('ROLE_USER') === true)
            return $this->redirect($this->generateUrl('frame_workers_tm_food_rescue_food_app_my_products'));


        return $this->render('FrameWorkersTMFoodRescueFoodAppBundle:Default:index.html.twig');
    }
}
