<?php
// src/FrameWorkersTm/FoodRescue/FoodAppBundle/Controller/RecipesController.php

namespace FrameWorkersTM\FoodRescue\FoodAppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class RecipesController extends Controller
{
    //TODO: Pasiklaust dėl login kūrimo
    public function __construct(){
        
    }
    
    public function indexAction(Request $request)
    {   
        $session = $request->getSession();
        $array['logged'] = $session->get('logged');
        return $this->render('FrameWorkersTMFoodRescueFoodAppBundle:Recipes:index.html.twig', $array);
    }
    
    public function RecipieViewAction($slug){
        $request = Request::createFromGlobals();
                
        
        
        return $this->render('FrameWorkersTMFoodRescueFoodAppBundle:Recipes:recipe.html.twig',array(
            'slug' => $slug
        ));
    }
    
}