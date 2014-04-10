<?php
// src/FrameWorkersTm/FoodRescue/FoodAppBundle/Controller/LoginController.php

namespace FrameWorkersTM\FoodRescue\FoodAppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LoginController extends Controller
{
    public function indexAction()
    {
        return $this->render('FrameWorkersTMFoodRescueFoodAppBundle:Login:index.html.twig');
    }
}