<?php
// src/FrameWorkersTm/FoodRescue/FoodAppBundle/Controller/RecipesController.php

namespace FrameWorkersTM\FoodRescue\FoodAppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use FrameWorkersTM\FoodRescue\FoodAppBundle\Entity\Recipes;
use FrameWorkersTM\FoodRescue\FoodAppBundle\Entity\Products;
use FrameWorkersTM\FoodRescue\FoodAppBundle\Entity\RecipesProducts;
use FrameWorkersTM\FoodRescue\FoodAppBundle\Entity\MyProducts;
use FrameWorkersTM\FoodRescue\FoodAppBundle\Services;


class RecipesController extends Controller
{
    //TODO: Pasiklaust dėl login kūrimo
    public function __construct(){
        
    }
    
    public function indexAction(Request $request, $limit=null)
    {
        /* deprecated
        $session = $request->getSession();
        $array['logged'] = $session->get('logged');
        */

        //get logged user id
        $usr= $this->get('security.context')->getToken()->getUser();
        if ($usr == 'anon.'){
            //cia tures eiti neprisijungusio vartotojo receptu atvaizdavimas pagal pridetus produktus
            //$userid = 0;
            $recipes = '';
            return $this->render('FrameWorkersTMFoodRescueFoodAppBundle:Recipes:index.html.twig', array('recipes' => $recipes, 'limit' => $limit));
        }
        else{
            $userid = $usr->getId();

//this should go on user login or access index page
//get trashed products
//$this->get('recipeservice')->findTrashedProducts($userid);

//update available recipes
$this->get('recipeservice')->findAndSaveAvailableUserRecipes($userid);

/* update available recipes */
/*
$time1 = microtime(true);
        //find available user recipes (on update insert remove)
//        $availableRecipes = $this->get('recipeservice')->findAvailableUserRecipes($userid);
//        $availableRecipes = $this->get('recipeservice')->findAvailableUserRecipes2($userid);
$time2 = microtime(true);
        //serialize data
//        $serializedRecipes = serialize($availableRecipes);
$time3 = microtime(true);
        //foreach ($availableRecipes as $key=>$a) { echo $key." "; print_r($a); echo "<br/>"; }
        //echo $serializedRecipes;

        //save available user recipes
//        $this->get('recipeservice')->saveAvailableUserRecipes($userid, $serializedRecipes);
$time4 = microtime(true);

$t1 = ($time2 - $time1) * 1000;
$t2 = ($time3 - $time2) * 1000;
$t3 = ($time4 - $time3) * 1000;
echo "regular microtimes: <br/>";
echo "find available recipes: ".$t1."<br/>";
echo "serialize recipes: ".$t2."<br/>";
echo "save recipes: ".$t3."<br/>";
*/

            //get recipe from service
            $recipes = $this->get('recipeservice')->findRecipes($userid, $limit);

            //old way
            //$recipes = $this->get('recipeservice')->findRecipesOldWay($userid, 2, $limit);

            /*
            if ($recipes){
                foreach ($recipes as $key=>$recipe){
                    echo $key." ".$recipe['id']." ".$recipe['name']." ".$recipe['products_nr']." ".$recipe['products_accepted']."<br/>";
                }
            }
            */

            return $this->render('FrameWorkersTMFoodRescueFoodAppBundle:Recipes:index.html.twig', array('recipes' => $recipes, 'limit' => $limit ));
        }
    }
    
    public function RecipieViewAction(Request $request, $recipeid){
        /* derpecated
        $session = $request->getSession();
        $array['logged'] = $session->get('logged');
        */

        //get logged user id
        $usr= $this->get('security.context')->getToken()->getUser();
        if ($usr == 'anon.'){
            //cia tures eiti neprisijungusio vartotojo receptu atvaizdavimas pagal pridetus produktus
            //kolkas ikeltas norecipe.
            //$userid = 0;
            //$recipes = '';
            return $this->render('FrameWorkersTMFoodRescueFoodAppBundle:Recipes:norecipe.html.twig');
        }
        else{
            $userid = $usr->getId();

            //get recipe
            $recipe = $this->get('recipeservice')->findRecipe($userid, $recipeid);

            //get recipe products
            $recipeProducts = $this->get('recipeservice')->findRecipeProducts($userid, $recipeid);

            //get user accepted products for recipe
            $acceptedProductsNr = $this->get('recipeservice')->getAcceptedProducts($recipeProducts);

            //generate recipe products form
            $form = $this->get('recipeservice')->buildMyProductsForm($this->createFormBuilder($recipeProducts),$recipeProducts,$recipe['id']);

            $form->handleRequest($request);

            //on cooked product - update my products quantities
            if ($form->isValid()) {
                $usedproducts = $form->getData();

                //update my products quantities
                $this->get('recipeservice')->updateMyProductsAfterCooked($userid, $usedproducts);

                //update available recipes for a user
                $this->get('recipeservice')->findAndSaveAvailableUserRecipes($userid);

                //redirect after cooked ?
                //return $this->redirect($this->generateUrl('frame_workers_tm_food_rescue_food_app_my_products'));
            }

            return $this->render('FrameWorkersTMFoodRescueFoodAppBundle:Recipes:recipe.html.twig',
                array('form' => $form->createView(), 'recipe' =>$recipe, 'recipe_products' => $recipeProducts, 'acceptedProdsNr' => $acceptedProductsNr)
            );
        }

    }
    
}

