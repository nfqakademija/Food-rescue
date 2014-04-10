<?php
// src/FrameWorkersTm/FoodRescue/FoodAppBundle/Controller/DashboardController.php

namespace FrameWorkersTM\FoodRescue\FoodAppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DashboardController extends Controller
{
    public function indexAction()
    {
        return $this->render('FrameWorkersTMFoodRescueFoodAppBundle:Dashboard:index.html.twig');
    }
}