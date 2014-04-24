<?php
// src/FrameWorkersTm/FoodRescue/FoodAppBundle/Controller/RecipesController.php

namespace FrameWorkersTM\FoodRescue\FoodAppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use FrameWorkersTM\FoodRescue\FoodAppBundle\Entity\Recipes;

class RecipesController extends Controller
{
    //TODO: Pasiklaust dėl login kūrimo
    public function __construct(){
        
    }
    
    public function indexAction(Request $request)
    {   
        $session = $request->getSession();
        $array['logged'] = $session->get('logged');
/* irasymui
        $recipe = new Recipes();
        $recipe->setName('A Foo Bar');
        $recipe->setPrice('19.99');
        $recipe->setDescription('Lorem ipsum dolor');

        $em = $this->getDoctrine()->getManager();
        $em->persist($recipe);
        $em->flush();
*/
        $recipe = $this->getDoctrine()
            ->getRepository('FrameWorkersTMFoodRescueFoodAppBundle:Recipes')
            ->find('1');
var_dump($recipe);
        if (!$recipe) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }


        return $this->render('FrameWorkersTMFoodRescueFoodAppBundle:Recipes:index.html.twig', $array);
    }
    
    public function RecipieViewAction(Request $request){
        $session = $request->getSession();
        $array['logged'] = $session->get('logged');
        
        
        return $this->render('FrameWorkersTMFoodRescueFoodAppBundle:Recipes:recipe.html.twig',$array);
    }
    
}