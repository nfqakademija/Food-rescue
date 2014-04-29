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

        $em = $this->getDoctrine()->getManager();
        $recipes = $em->getRepository('FrameWorkersTMFoodRescueFoodAppBundle:Recipes')
            ->findRecipes(1);

        var_dump($recipes);
        foreach ($recipes as $recipe){
            //echo $recipe->getName()."<br/>";
        }
//get products from recipe
        //$em = $this->getDoctrine()->getManager();
        //$products = $em->getRepository('FrameWorkersTMFoodRescueFoodAppBundle:Recipes')
        //    ->findAllProductsByRecipeId(1);
        //var_dump($products);
        //foreach ($products as $product){
            //echo $product->getproductsId()->getName()."<br/>";
        //}

//get first 10 recipes names
        //$em = $this->getDoctrine()->getManager();
        //$products = $em->getRepository('FrameWorkersTMFoodRescueFoodAppBundle:Recipes')
        //    ->getProducts();
        //var_dump($products['0']->getName());
        //var_dump($products['0']->getRecipes());




       // foreach ($b as $a){
            //var_dump($a);
       // }
        //foreach ($products as $product){
           //echo $product['0']->getName()."<br/>";
          // var_dump($product['0']->getRecipeProducts()); echo "<br/>";
        //}

        //$rep = $this->getDoctrine()
        //    ->getRepository('FrameWorkersTMFoodRescueFoodAppBundle:Recipes');
        //$product = $rep->findOneBy(
        //    array('id' => '1'));
        //echo "recipe by id:"; var_dump($product->getRecipes()); echo "<br/>";

        //$rep = $this->getDoctrine()
        //    ->getRepository('FrameWorkersTMFoodRescueFoodAppBundle:RecipesProducts');
        //$product = $rep->findAll();



        // query by the primary key (usually "id")
        //$product = $repository->find($id);
        //echo "recipe by id:"; var_dump($product); echo "<br/>";

        // dynamic method names to find based on a column value
        //$product = $repository->findOneById($id);
        //echo "recipe by id:"; var_dump($product); echo "<br/>";

        //rasti viena produkta pagal pavadinima
       // $product = $repository->findOneByName('Blyneliai');
       // var_dump($product);

        // find *all* products
       // $products = $repository->findAll();
       // echo "all recipes:"; var_dump($products); echo "<br/>";

        // find a group of products based on an arbitrary column value
        //$products = $repository->findByName('Blyneliai');
        //echo "recipes by name:"; var_dump($products); echo "<br/>";

        // query for one product matching be name and price
       // $product = $repository->findOneBy(
        //    array('name' => 'Blyneliai', 'price' => 19.99)
        //);

        // query for all products matching the name, ordered by price
        //$products = $repository->findBy(
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
//var_dump($products);
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
        //var_dump($products['0']);


        //$product = $this->getDoctrine()
         //   ->getRepository('FrameWorkersTMFoodRescueFoodAppBundle:Recipes')
        //    ->find('1');
        //var_dump($product);
        //$categoryName = $product->getaa()->getName();
        //$product->getCategory()->getProductsId();
        //$products->getName();



        return $this->render('FrameWorkersTMFoodRescueFoodAppBundle:Recipes:index.html.twig', $array);
    }
    
    public function RecipieViewAction(Request $request){
        $session = $request->getSession();
        $array['logged'] = $session->get('logged');
        
        
        return $this->render('FrameWorkersTMFoodRescueFoodAppBundle:Recipes:recipe.html.twig',$array);
    }
    
}