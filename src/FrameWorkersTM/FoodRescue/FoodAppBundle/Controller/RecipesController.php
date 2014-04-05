<?php
// src/FrameWorkersTm/FoodRescue/FoodAppBundle/Controller/RecipesController.php

namespace FrameWorkersTM\FoodRescue\FoodAppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RecipesController extends Controller
{
    public function indexAction()
    {
        return $this->render('FrameWorkersTMFoodRescueFoodAppBundle:Recipes:index.html.twig');
    }
}