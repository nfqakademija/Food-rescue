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
    
    public function indexAction(Request $request)
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
            return $this->render('FrameWorkersTMFoodRescueFoodAppBundle:Recipes:index.html.twig', array('recipes' => $recipes));
        }
        else{
            $userid = $usr->getId();

            /* testitnis isvedimas is serviso
            $greeter = $this->get('recipeservice');
            echo $greeter->greet('rolkis');
            */

            // seperator = 2 means we must have at least half products for recipe
            // this variable is divided from recipe product's number, so 2 means f.e. 8/2 - half products user must have
            $seperator = 2;

            //get recipe from service
            $recipes = $this->get('recipeservice')->findRecipes($userid, $seperator);

            /* DEPRECTAED. get recipes regular way
            $em = $this->getDoctrine()->getManager();
            $recipes = $em->getRepository('FrameWorkersTMFoodRescueFoodAppBundle:Recipes')
                ->findRecipesByUserNativeSQL($userid, $seperator);
            */

            /* test spausdinimas
            if ($recipes){
                foreach ($recipes as $key=>$recipe){
                    echo $key." ".$recipe['id']." ".$recipe['name']." ".$recipe['products_nr']." ".$recipe['products_accepted']."<br/>";
                }
            }
            */

            return $this->render('FrameWorkersTMFoodRescueFoodAppBundle:Recipes:index.html.twig', array('recipes' => $recipes));
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
/* DEPRECATED get recipe and recipe products regular way

            $em = $this->getDoctrine()->getManager();
            $recipe = $em->getRepository('FrameWorkersTMFoodRescueFoodAppBundle:Recipes')
                ->findRecipeNativeSQL($userid, $recipeid);

            //escape special chars.
            $recipe['describtion'] = html_entity_decode($recipe['describtion'] );

             $em = $this->getDoctrine()->getManager();
             $recipeProducts = $em->getRepository('FrameWorkersTMFoodRescueFoodAppBundle:Recipes')
                 ->findRecipeProductsNativeSQL($recipeid);

*/
            //get recipe from service
            $recipe = $this->get('recipeservice')->findRecipe($userid, $recipeid);

            //get recipe products from service
            $recipeProducts = $this->get('recipeservice')->findRecipeProducts($userid, $recipeid);

            //get user accepted products for recipe
            $acceptedProductsNr = $this->get('recipeservice')->getAcceptedProducts($recipeProducts);

            // generate recipe products form
            $form = $this->get('recipeservice')->buildMyProductsForm($this->createFormBuilder($recipeProducts),$recipeProducts,$recipe['id']);

/* perkelta i servisa
            //get user accepted products for recipe
            $acceptedProductsNr = 0;

            //add products to form
            $formBuilder = $this->createFormBuilder($recipeProducts);

            foreach($recipeProducts as $key=>$product){
               //print_r($product); echo "<br/>";
                $formBuilder->add('prod_name_'.$key, 'text', array('label' => $product['name'].'('.$product['unit'].')', 'data' => $product['quantity']));

                if ( $product['my_product_id'] != null ){
                    $acceptedProductsNr++;
                }
            }
            $formBuilder->add('save', 'submit', array('label'  => 'Pagaminau'));
            $form = $formBuilder->getForm();
*/

            $form->handleRequest($request);

            //on cooked product - update my products quantities
            if ($form->isValid()) {
                $usedproducts = $form->getData();
                //update my products quantities
                $this->get('recipeservice')->updateMyProductsAfterCooked($usedproducts);

/* DEPRECATED. old way to update quantities
                $usedproducts = $form->getData();
                foreach($usedproducts as $key=>$usedproduct){
                    if (isset($usedproduct['id'])){
 print_r($usedproduct); echo "<br/>";
                        //update quantity of products that i have
                        if($usedproduct['my_product_id']){
 echo "turim ";
                            $myproduct = $this->getDoctrine()
                                ->getRepository('FrameWorkersTMFoodRescueFoodAppBundle:MyProducts')
                                ->findOneById($usedproduct['my_product_id']);

                            $oldQuantity  = $myproduct->getQuantity();
                            $usedQuantity = $usedproduct['quantity'];
                            $newQuantity  = $oldQuantity - $usedQuantity;

echo " old: ".$oldQuantity." used: ".$usedQuantity." new: ".$newQuantity." ";
if ($newQuantity > 0){     echo " dar turim"; }
else{     echo " nebeliko "; }

                            if ($newQuantity < 1){
                                $newQuantity = 0;
                            }

                            //atnaujiname my_products lentos produktus
                            $myproduct->setQuantity($newQuantity);
                            $em2 = $this->getDoctrine()->getManager();
                            $em2->persist($myproduct);
                            $em2->flush();
                         }
 echo "<br/>";
                    }
                }
echo "<br/>";
 */

                //redirect after cooked
                return $this->redirect($this->generateUrl('frame_workers_tm_food_rescue_food_app_my_products'));

            }


            return $this->render('FrameWorkersTMFoodRescueFoodAppBundle:Recipes:recipe.html.twig',
                array('form' => $form->createView(), 'recipe' =>$recipe, 'recipe_products' => $recipeProducts, 'acceptedProdsNr' => $acceptedProductsNr)
            );
        }

    }
    
}

