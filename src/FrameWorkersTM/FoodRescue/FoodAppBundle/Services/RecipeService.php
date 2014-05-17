<?php
namespace FrameWorkersTM\FoodRescue\FoodAppBundle\Services;

#use FrameWorkersTM\FoodRescue\FoodAppBundle\Entity\Recipes;
use FrameWorkersTM\FoodRescue\FoodAppBundle\Entity\UsersRecipes;
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
        $formBuilder->add('recipe_liked', 'checkbox', array('label' => 'Click if you liked it', 'required' => false));
        $formBuilder->add('save', 'submit', array('label'  => 'Pagaminau'));
        return $formBuilder->getForm();
    }

    // update my_products products quantities and user_recipes cooked,liked
    public function updateMyProductsAfterCooked($userid, $usedproducts){
        foreach($usedproducts as $key=>$usedproduct){
            if (isset($usedproduct['id'])){
                //update quantity of products that i have
                if($usedproduct['my_product_id']){

print_r($usedproduct); echo "<br/>";

                    // update product quantity
                    self::updateProductQuantity($usedproduct['my_product_id'], $usedproduct['quantity'] );

                    //update users_recipes table, set recipe as cooked and/or liked
                    self::updateUsersRecipes($userid, $usedproducts['recipe_id'], $usedproducts['recipe_liked'] );

/* DEPRECATED. old way. too long
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

                   $myproduct->setQuantity($newQuantity);

                   //update product quantities
                   self::insertUpdateTable($myproduct);
*/

 /* DEPRECATED.

                    $rep = $this->doctrine->getRepository('FrameWorkersTMFoodRescueFoodAppBundle:UsersRecipes');
                    $userRecipe = $rep->findOneBy(
                        array('usersId' => $userid, 'recipesId' => $usedproducts['recipe_id']));

                    if ($userRecipe){
                        //update existing user recipe
echo "update userRecipe<br/>";
                        if ($usedproducts['recipe_liked'] == true){
                            $userRecipe->setLiked('1');
                        }
                    }
                    else{
                        //insert new user recipe
 echo "insert userRecipe<br/>";
                        $userRecipe = new UsersRecipes();
                        $userRecipe->setUsersId($userid);
                        $userRecipe->setRecipesId($usedproducts['recipe_id']);
                        $userRecipe->setCooked('1');
                        if ($usedproducts['recipe_liked'] == true){
                            $userRecipe->setLiked('1');
                        }
                    }
                    //update userRecipes table. set recipe as cooked and/or liked
                    self::insertUpdateTable($userRecipe);
*/
                }
            }
        }
    }

    // update product quantity in db
    public function updateProductQuantity($product_id, $usedQuantity){
        $myproduct = $this->doctrine->getRepository('FrameWorkersTMFoodRescueFoodAppBundle:MyProducts')
            ->findOneById($product_id);

        $oldQuantity  = $myproduct->getQuantity();
        //$usedQuantity = $usedproduct['quantity'];
        $newQuantity  = $oldQuantity - $usedQuantity;

echo " old: ".$oldQuantity." used: ".$usedQuantity." new: ".$newQuantity." <br/>";

        if ($newQuantity < 1){
            // remove product from my_products table;
            self::deleteRowFromTable($myproduct);
        }
        else{
            //update product quantities
            $myproduct->setQuantity($newQuantity);
            self::insertUpdateTable($myproduct);
        }

    }

    // update user recipe cooked and/or liked in db
    public function updateUsersRecipes($userid, $recipeid, $liked){

        $rep = $this->doctrine->getRepository('FrameWorkersTMFoodRescueFoodAppBundle:UsersRecipes');
        $userRecipe = $rep->findOneBy(
            array('usersId' => $userid, 'recipesId' => $recipeid));

        if ($userRecipe){
            //update existing user recipe
            if ($liked == true){
                $userRecipe->setLiked('1');
            }
        }
        else{
            //insert new userRecipe
            $userRecipe = new UsersRecipes();
            $userRecipe->setUsersId($userid);
            $userRecipe->setRecipesId($recipeid);
            $userRecipe->setCooked('1');
            if ($liked == true){
                $userRecipe->setLiked('1');
            }
        }
        //update userRecipes table. set recipe as cooked and/or liked
        self::insertUpdateTable($userRecipe);
    }

    // insert or update db data
    public function insertUpdateTable($object){
        $em = $this->doctrine->getManager();
        $em->persist($object);
        $em->flush();
    }

    // remove row from db
    public function deleteRowFromTable($object){
        $em = $this->doctrine->getManager();
        $em->remove($object);
        $em->flush();
    }
}