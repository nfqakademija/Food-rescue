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

class RecipesController extends Controller
{
    //TODO: Pasiklaust dėl login kūrimo
    public function __construct(){
        
    }
    
    public function indexAction(Request $request)
    {   
        $session = $request->getSession();
        $array['logged'] = $session->get('logged');

        $userid = 1;  // user id
        $quantity =2; // 2 - reiskia kad turim tureti bent puse produktu ieinanciu i recepta kad ji paselectinti

        /* Receptu paemimas, kai turim bent puse receptui reikalingu produktu */
        /* blogai supranta query kur in array naudojama, todel neteisingai grazina receptus

        $em = $this->getDoctrine()->getManager();
        $recipes = $em->getRepository('FrameWorkersTMFoodRescueFoodAppBundle:Recipes')
           ->findRecipesByUser($userid, $quantity);

        foreach ($recipes as $key=>$recipe){
           echo $key." ".$recipe->getId()." ".$recipe->getName()."<br/>";
           //$recipeProducts =$recipe->getProducts();
           //$name = $recipeProducts['0']->getProduct();
          // print_r($name->getName()); echo "<br/>";

        }
        echo "<hr/>";
        */

        //native query teisingai grazina receptus
        $em = $this->getDoctrine()->getManager();
        $recipes = $em->getRepository('FrameWorkersTMFoodRescueFoodAppBundle:Recipes')
            ->findRecipesByUserNativeSQL($userid, $quantity);
/*
        if ($recipes){
            foreach ($recipes as $key=>$recipe){
                echo $key." ".$recipe['id']." ".$recipe['name']." ".$recipe['products_nr']." ".$recipe['products_accepted']."<br/>";
            }
        }
*/
        return $this->render('FrameWorkersTMFoodRescueFoodAppBundle:Recipes:index.html.twig', array('recipes' => $recipes));
    }
    
    public function RecipieViewAction(Request $request, $recipeid){
        $session = $request->getSession();
        $array['logged'] = $session->get('logged');

        //$recipe = $this->getDoctrine()
        //    ->getRepository('FrameWorkersTMFoodRescueFoodAppBundle:Recipes')
        //    ->findOneById($recipeid);

        $userid = 1;

        //get recipe
        $em = $this->getDoctrine()->getManager();
        $recipe = $em->getRepository('FrameWorkersTMFoodRescueFoodAppBundle:Recipes')
            ->findRecipeNativeSQL($userid, $recipeid);

        //get recipe products
        $em = $this->getDoctrine()->getManager();
        $recipeProducts = $em->getRepository('FrameWorkersTMFoodRescueFoodAppBundle:Recipes')
            ->findRecipeProductsNativeSQL($recipeid);

        //get user accepted products for recipe
        $acceptedProductsNr = 0;
        //add products to form
        $formBuilder = $this->createFormBuilder($recipeProducts);

        foreach($recipeProducts as $key=>$product){
            $formBuilder->add('prod_name_'.$key, 'text', array('label' => $product['name'].'('.$product['unit'].')', 'data' => $product['quantity']));

            if ( $product['myproduct'] != null ){
                $acceptedProductsNr++;
            }
        }
        $formBuilder->add('save', 'submit', array('label'  => 'Pagaminau'));
        $form = $formBuilder->getForm();

        $form->handleRequest($request);
        if ($form->isValid()) {
            ///eiti per my products lenta
            //selectinti panaudotus produktu quantity ir atimti panaudota quantity

            //print_r($form->getData());
            //echo "<br/>";
            $myproducts = $form->getData();
            foreach($myproducts as $key=>$myproduct){
                if (isset($myproduct['id'])){
                    //echo $key."<br/>";
                    //echo $myproduct['id']." ".$myproduct['name']." ".$myproduct['quantity']."<br/>";
                  /*
                    if ($myproduct['id'] == 4){
                    $myprod = $this->getDoctrine()
                        ->getRepository('FrameWorkersTMFoodRescueFoodAppBundle:MyProducts')
                        ->findOneById($myproduct['id']);
                    $myprod->setQuantity(1);
                    $em2 = $this->getDoctrine()->getManager();
                    $em2->persist($myprod);
                    $em2->flush();
                  }
                  */
                }


            }
            //echo "<br/>";

            //return $this->redirect($this->generateUrl('frame_workers_tm_food_rescue_food_app_my_products'));
        }

        return $this->render('FrameWorkersTMFoodRescueFoodAppBundle:Recipes:recipe.html.twig',
            array('form' => $form->createView(), 'recipe' =>$recipe, 'recipe_products' => $recipeProducts, 'acceptedProdsNr' => $acceptedProductsNr)
        );

    }
    
}

/* DEMO recepto su produktu irasymas su sarysiu !!
        $recipe = new Recipes();
        $recipe->setName('naujas receptas');
        $recipe->setDescribtion('cia apibudinimas');
        $recipe->setImageName('cia kelias');

        $product = new Products();
        $product->setName('Pienas4');
        $product->setPrice('10');
        $product->setQuantity('2');
        $product->setUnit('1');
        $product->setEndDays('1');

        $recipe_product = new RecipesProducts();
        $recipe_product->setRecipe($recipe);
        $recipe_product->setProduct($product);
        $recipe_product->setQuantity('11');
        $recipe_product->setUnit('');

        // issaugojimas
        $em = $this->getDoctrine()->getManager();
        //$em->persist($recipe);
        //$em->persist($product);
        $em->persist($recipe_product);
        $em->flush();

        echo 'Created recipe id: '.$recipe->getId().'<br/>';
        echo 'Created product id: '.$product->getId() .'<br/>';
        echo 'Created recipe_product id: '.$recipe_product->getId()  .'<br/>';
*/

/* DEMO recepto produktu arvaizdavimas pagal recepto ID

        $recipe = $this->getDoctrine()
            ->getRepository('FrameWorkersTMFoodRescueFoodAppBundle:Recipes')
            ->find('3');

        $recipeProducts = $recipe->getProducts();

        foreach($recipeProducts as $p) {
            $prod = $p->getProduct();
            echo $prod->getName();
        }
*/

// OTHER SAMPLES

//$rep = $this->getDoctrine()
//    ->getRepository('FrameWorkersTMFoodRescueFoodAppBundle:Recipes');
//$product = $rep->findOneBy(
//    array('id' => '1'));
//echo "recipe by id:"; var_dump($product->getRecipes()); echo "<br/>";


//$rep = $this->getDoctrine()
//    ->getRepository('FrameWorkersTMFoodRescueFoodAppBundle:RecipesProducts');
//$product = $rep->findAll();


// query by the primary key (usually "id")
//$recipe = $repository->find($id);
//echo "recipe by id:"; var_dump($recipe); echo "<br/>";


// dynamic method names to find based on a column value
//$recipe = $repository->findOneById($id);
//echo "recipe by id:"; var_dump($recipe); echo "<br/>";


//rasti viena recepta pagal pavadinima
// $recipe = $repository->findOneByName('Blyneliai');
// var_dump($recipe);


// find *all* recipes
// $recipes = $repository->findAll();
// echo "all recipes:"; var_dump($recipes); echo "<br/>";


// find a group of products based on an arbitrary column value
//$recipe = $repository->findByName('Blyneliai');
//echo "recipes by name:"; var_dump($recipe); echo "<br/>";


// query for one product matching be name and price
// $product = $repository->findOneBy(
//    array('name' => 'Blyneliai', 'price' => 19.99)
//);


// query for all products matching the name, ordered by price
//$recipes = $repository->findBy(
//    array('name' => 'foo'),
//    array('price' => 'ASC')
//);


//query builder
// get all recipes DESC
/*
$repository = $this->getDoctrine()
    ->getRepository('FrameWorkersTMFoodRescueFoodAppBundle:Recipes');

$query = $repository->createQueryBuilder('p')
    ->where('p.name > :namee')
    ->setParameter('namee', 'Blyneliai')
    ->orderBy('p.name', 'DESC')
    ->getQuery();

$products = $query->getResult();
*/



//getResult() get an array of results.
//getSingleResult() get one result (which throws exception there is no result) so use this below
//getOneOrNullResult()



//DQL
/*
$em = $this->getDoctrine()->getManager();
$query = $em->createQuery(
    'SELECT p
    FROM FrameWorkersTMFoodRescueFoodAppBundle:Recipes p
    WHERE p.name = :namee
    ORDER BY p.name ASC'
)->setParameter('namee', 'Blyneliai');

$products = $query->getResult();
*/


/* DOCTRININIS KELIAS PASIMTI RECEPTUS - LETAS !

        // pasiemam turimu produktu id
        $myproducts = $this->getDoctrine()
            ->getRepository('FrameWorkersTMFoodRescueFoodAppBundle:MyProducts')
            ->findAll();

        //surasom juos i masyva
        $i = 0;
        $myProductsIds = [];
        foreach ($myproducts as $myproduct){
            $myProductsIds[$i] = $myproduct->getProductId();
            $i++;
        }

        //randam receptus,
        $recipes = $this->getDoctrine()
            ->getRepository('FrameWorkersTMFoodRescueFoodAppBundle:Recipes')
            ->findAll();

            // ->setMaxResults('10');
            // http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/reference/dql-doctrine-query-language.html#first-and-max-result-items-dql-query-only
            //Query::setMaxResults($maxResults)
            //Query::setFirstResult($offset)

        //paimam receptus, kai turim puse ir daugiau tinkanciu produktu
        $i = 0;
        foreach($recipes as $recipe){
            $count = 0;
            //echo $recipe->getName().":<br/>";
            $recipeProducts = $recipe->getProducts();
            //echo "<ul>";
            foreach($recipeProducts as $p) {
                // echo "<li>".$p->getProduct()->getId()." ";
                if (in_array($p->getProduct()->getId(), $myProductsIds)) {
                    //echo " TURIM";
                    $count++;
                }
                ///echo "</li>";
             }
           // echo "</ul><br/>";

             if ( $count >= $recipe->getProductsNr()/2 ){
                $filteredRecipes[$i] = $recipe;
                $i++;
            }
        }

        //spausdinam rastus receptus
        echo "rasta receptu: ".$i."<br/>";

        if ($filteredRecipes){
            foreach($filteredRecipes as $recipe){
                echo $recipe->getName().":<br/>";

                $recipeProducts = $recipe->getProducts();

                //echo "<ul>";
                foreach($recipeProducts as $p) {
                    //echo "<li>".$p->getProduct()->getId()." ";
                    if (in_array($p->getProduct()->getId(), $myProductsIds)) {
                    //    echo " TURIM";
                    }
                    //echo "</li>";
                }
                //echo "</ul><br/>";

            }
        }
*/