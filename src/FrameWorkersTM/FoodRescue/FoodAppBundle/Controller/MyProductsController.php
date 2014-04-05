<?php
// src/FrameWorkersTm/FoodRescue/FoodAppBundle/Controller/MyProductsController.php

namespace FrameWorkersTM\FoodRescue\FoodAppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MyProductsController extends Controller
{
    public function indexAction()
    {
        return $this->render('FrameWorkersTMFoodRescueFoodAppBundle:MyProducts:index.html.twig');
    }
}