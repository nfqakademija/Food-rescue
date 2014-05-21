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
        $userId = $this->get('recipeservice')->findUser($request->getSession());

        return $this->render('FrameWorkersTMFoodRescueFoodAppBundle:Default:index.html.twig');
    }
}
