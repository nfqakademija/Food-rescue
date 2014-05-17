<?php
namespace FrameWorkersTM\FoodRescue\FoodAppBundle\Services;

#use FrameWorkersTM\FoodRescue\FoodAppBundle\Entity\Recipes;
use Symfony\Component\Form\FormBuilderInterface;

class RecipeService
{
    protected $doctrine;

    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /* DEPRECATED. for testing only */
    public function greet($name)
    {
        //return $this->greeting . ' ' . $name;
        return $name;
    }

    //get recipes
    public function findRecipes($userid, $seperator, $limit=null){
        $recipes = $this->doctrine->getRepository('FrameWorkersTMFoodRescueFoodAppBundle:Recipes')
            ->findRecipesByUserNativeSQL($userid, $seperator, $limit);
        return $recipes;
    }

    // get recipe
    public function findRecipe($userid, $recipeid){
        $recipe = $this->doctrine->getRepository('FrameWorkersTMFoodRescueFoodAppBundle:Recipes')
            ->findRecipeNativeSQL($userid, $recipeid);

        //escape special chars like &amp;
        $recipe['describtion'] = html_entity_decode($recipe['describtion'] );

        return $recipe;
    }

    // get recipe products
    public function findRecipeProducts($userid, $recipeid){
        $recipeProducts = $this->doctrine->getRepository('FrameWorkersTMFoodRescueFoodAppBundle:Recipes')
            ->findRecipeProductsNativeSQL($userid, $recipeid);
        return $recipeProducts;
    }

    // get accepted products
    public function getAcceptedProducts($recipeProducts){
        $acceptedProductsNr = 0;
        foreach($recipeProducts as $product){
            if ( $product['my_product_id'] != null ){
                $acceptedProductsNr++;
            }
        }
        return $acceptedProductsNr;
    }

    // generate recipe products form with quantities (for updating)
    public function buildMyProductsForm(FormBuilderInterface $formBuilder, $recipeProducts, $recipeid){
        foreach($recipeProducts as $key=>$product){
            $formBuilder->add('prod_name_'.$key, 'text', array('label' => $product['name'].'('.$product['unit'].')', 'data' => $product['quantity']));
        }
        $formBuilder->add('recipe_id', 'hidden', array('label' => 'recipe_id', 'data' => $recipeid));
        $formBuilder->add('recipe_liked', 'checkbox', array('label' => 'Click if you liked it', 'required' => 'false'));
        $formBuilder->add('save', 'submit', array('label'  => 'Pagaminau'));
        return $formBuilder->getForm();
    }

    // update my_products products quantities
    public function updateMyProductsAfterCooked($usedproducts){
        foreach($usedproducts as $key=>$usedproduct){
            if (isset($usedproduct['id'])){

                //update quantity of products that i have
                if($usedproduct['my_product_id']){

                    $myproduct = $this->doctrine->getRepository('FrameWorkersTMFoodRescueFoodAppBundle:MyProducts')
                        ->findOneById($usedproduct['my_product_id']);

                    $oldQuantity  = $myproduct->getQuantity();
                    $usedQuantity = $usedproduct['quantity'];
                    $newQuantity  = $oldQuantity - $usedQuantity;

print_r($usedproduct); echo "<br/>";
echo " old: ".$oldQuantity." used: ".$usedQuantity." new: ".$newQuantity." ";

                    if ($newQuantity < 1){
                        $newQuantity = 0;
                    }

                    //update product quantities
                    $myproduct->setQuantity($newQuantity);
                    $em = $this->doctrine->getManager();
                    $em->persist($myproduct);
                    $em->flush();

                }
            }
        }
    }

    public function setRecipeAsCooked(){

    }


}