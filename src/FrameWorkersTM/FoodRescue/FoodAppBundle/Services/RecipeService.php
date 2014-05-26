<?php
namespace FrameWorkersTM\FoodRescue\FoodAppBundle\Services;

#use FrameWorkersTM\FoodRescue\FoodAppBundle\Entity\Recipes;
use FrameWorkersTM\FoodRescue\FoodAppBundle\Entity\MyProductsTrashed;
use FrameWorkersTM\FoodRescue\FoodAppBundle\Entity\UsersRecipes;
use FrameWorkersTM\FoodRescue\FoodAppBundle\Entity\UsersAvailableRecipes;
use Symfony\Component\Form\FormBuilderInterface;

class RecipeService
{
    protected $doctrine;

    protected $context;
    protected $user_manager;
    protected $encoder_factory;

    public function __construct($doctrine,$context,$user_manager,$encoder_factory)
    {
        $this->doctrine = $doctrine;
        $this->context = $context;
        $this->user_manager = $user_manager;
        $this->encoder_factory = $encoder_factory;
    }

    // move demo user products to registered user
    public function addNewUserProductsFromDemo($userid, $guestUserId){
       $this->doctrine->getRepository('FrameWorkersTMFoodRescueFoodAppBundle:Recipes')
            ->addNewUserProductsFromDemoNativeSQL($userid, $guestUserId);
    }

    //get user id
    // return user_id if logged in
    // return guest_user_id if exist in cookies
    // return created guest_user_id and set it in cookies
    public function findUser($request){
        $usr = $this->context->getToken()->getUser();
        if ($usr == 'anon.') {
            //user is not logged
            $session = $request; //$request->getSession();
            $guestUser= $session->get('guest_user_id');
            if (!($guestUser)){
                //not logged in, no guest user found in cookies - create a demo user

                //generate demo user info
                $random_number = mt_rand(0,9).mt_rand(0,9).mt_rand(0,9).mt_rand(0,9).mt_rand(0,9).mt_rand(0,9).mt_rand(0,9);
                $username = $random_number;
                $email    = $random_number;
                $password = $random_number;

                $userManager = $this->user_manager; //$this->get('fos_user.user_manager');
                $user = $userManager->createUser();
                $user->setUsername($username);
                $user->setEmail($email);

                //encode password
                $encoder_service = $this->encoder_factory; //$this->get('security.encoder_factory');
                $encoder = $encoder_service->getEncoder($user);
                $encoded_pass = $encoder->encodePassword($password, $user->getSalt());
                $user->setPlainPassword($encoded_pass);

                //save user
                $userManager->updateUser($user);

                //set cookie
                $session->set('guest_user_id', $user->getId());
//echo "naujas demo vartotojas. user_id: ".$user->getId()."<br/>";

                //new guest user
                return $user->getId();
            }
            else{
//echo "demo vartotojas egzsituoja. user_id: ".$guestUser."<br/>";
                //guest user exist
                return $guestUser;
            }
        }
        else{
            //user is logged in
            return $usr->getId();
        }
    }

    // get trashed products and write them to trashed products table
    public function findTrashedProducts($userid,$request){
        $trashedProducts = $this->doctrine->getRepository('FrameWorkersTMFoodRescueFoodAppBundle:Recipes')
            ->findTrashedProductsNativeSQL($userid);
        if ($trashedProducts){
            $namesArray = array();
            foreach($trashedProducts as $key=>$trashedProduct){
                $product = $this->doctrine->getRepository('FrameWorkersTMFoodRescueFoodAppBundle:MyProductsTrashed')
                    ->findOneBy(array('userId' => $userid, 'productId' => $trashedProduct['product_id']));

                if ($product){
                    //update trashed product
                    $oldQuantity = $product->getQuantity();
                    $newQuantity = $oldQuantity + $trashedProduct['quantity'];
                    $product->setQuantity($newQuantity);
                    self::insertUpdateTable($product);
                }
                else{
                    //insert new trashed product
                    $product = new MyProductsTrashed();
                    $product->setUserId($userid);
                    $product->setProductId($trashedProduct['product_id']);
                    $product->setQuantity($trashedProduct['quantity']);
                    self::insertUpdateTable($product);
                }

                // remove product from my_products table
                $myproduct = $this->doctrine->getRepository('FrameWorkersTMFoodRescueFoodAppBundle:MyProducts')
                    ->findOneBy(array('userId' => $userid, 'product' => $trashedProduct['product_id']));
                if ($myproduct){
                    self::deleteRowFromTable($myproduct);
                }

                //get trashed product name
                $prod = $this->doctrine->getRepository('FrameWorkersTMFoodRescueFoodAppBundle:Products')
                    ->findOneById($trashedProduct['product_id']);
                $namesArray[$key] = $prod->getName();
            }
            //set message
            $request->getSession()->getFlashBag()->set('notice', 'Pasibaigė šių produktų galiojimo laikas: '.implode(',',$namesArray));

            //find available recipes
            self::findAndSaveAvailableUserRecipes($userid);
        }


    }

    // find and save available user recipes
    public function findAndSaveAvailableUserRecipes($userid){
//$time1 = microtime(true);
        //find available user recipes
        $availableRecipes = self::findAvailableUserRecipes($userid);
//$time2 = microtime(true);
        if ($availableRecipes){
            //serialize data
            $serializedRecipes = serialize($availableRecipes);
//$time3 = microtime(true);

            //foreach ($availableRecipes as $key=>$a) { echo $key." "; print_r($a); echo "<br/>"; }
            //echo $serializedRecipes;

            //save available user recipes
            self::saveAvailableUserRecipes($userid, $serializedRecipes);

//$time4 = microtime(true);

//$t1 = ($time2 - $time1);
//$t2 = ($time3 - $time2);
//$t3 = ($time4 - $time3);

//echo "find and save available recipes service: <br/>";
//echo "find available recipes: ".number_format($t1,3)."<br/>";
//echo "serialize recipes: ".number_format($t2,3)."<br/>";
//echo "save serialized user recipes to db: ".number_format($t3,3)."<br/>";

        }
        else{
            //if user have no more products
            self::saveAvailableUserRecipes($userid, '');
        }

    }

    // count available recipes for user
    public function findAvailableUserRecipes($userid){
        // seperator = 2 means we must have at least half products for recipe
        // this variable is divided from recipe product's number, so 2 means f.e. 8/2 - half products user must have
        $seperator = 2;
        $recipes = $this->doctrine->getRepository('FrameWorkersTMFoodRescueFoodAppBundle:Recipes')
            ->findAvailableUserRecipesNativeSQL($userid, $seperator);

        return $recipes;
    }

    // save user available recipes
    public function saveAvailableUserRecipes($userid, $data){
        $userAvailableRecipes = $this->doctrine->getRepository('FrameWorkersTMFoodRescueFoodAppBundle:UsersAvailableRecipes')
            ->findOneByUserId($userid);

        if ($userAvailableRecipes){
            //update recipe ids
            $userAvailableRecipes->setRecipesId($data);
        }
        else{
            //insert new row
            $userAvailableRecipes = new UsersAvailableRecipes();
            $userAvailableRecipes->setUserId($userid);
            $userAvailableRecipes->setRecipesId($data);
        }
        self::insertUpdateTable($userAvailableRecipes);
    }

    // get saved available user recipes (recipes page)
    public function findRecipes($userid, $limit=null){
        $availableRecipes = $this->doctrine->getRepository('FrameWorkersTMFoodRescueFoodAppBundle:UsersAvailableRecipes')
            ->findOneByUserId($userid);

        if (!$availableRecipes){ return; }
        // additional check (if all user products was deleted, then this field is empty)
        if (!empty($availableRecipes->getRecipesId())){
            $availableRecipes = unserialize($availableRecipes->getRecipesId());
//foreach($availableRecipes as $key=>$r){ echo $key." "; print_r($r); echo "<br/>"; }
            if (!empty($limit)){
                $recipes = array_slice($availableRecipes, 0, $limit);
            }
            else{
                $recipes = array_slice($availableRecipes, 0, 15);
            }
            return $recipes;
        }
    }

    //get random recipes
    public function findRandomRecipes($userid, $limit=null){
        $recipes = $this->doctrine->getRepository('FrameWorkersTMFoodRescueFoodAppBundle:Recipes')
            ->findRandomRecipesNativeSQL($userid, $limit);
        return $recipes;
    }

    // DEPRECATED - get available recipes (bad way cause of making calculations)(recipes page)
    public function findRecipesOldWay($userid, $seperator, $limit=null){
        $recipes = $this->doctrine->getRepository('FrameWorkersTMFoodRescueFoodAppBundle:Recipes')
            ->findRecipesByUserNativeSQL($userid, $seperator, $limit);
        return $recipes;
    }

    // get recipe (recipe page)
    public function findRecipe($userid, $recipeid){
        $recipe = $this->doctrine->getRepository('FrameWorkersTMFoodRescueFoodAppBundle:Recipes')
            ->findRecipeNativeSQL($userid, $recipeid);

        //escape special chars like &amp;
        $recipe['describtion'] = html_entity_decode($recipe['describtion'] );

        return $recipe;
    }

    // get recipe products (recipe page)
    public function findRecipeProducts($userid, $recipeid){
        $recipeProducts = $this->doctrine->getRepository('FrameWorkersTMFoodRescueFoodAppBundle:Recipes')
            ->findRecipeProductsNativeSQL($userid, $recipeid);
        return $recipeProducts;
    }

    // get accepted products (recipe page)
    public function getAcceptedProducts($recipeProducts){
        $acceptedProductsNr = 0;
        foreach($recipeProducts as $product){
            if ( $product['my_product_id'] != null ){
                $acceptedProductsNr++;
            }
        }
        return $acceptedProductsNr;
    }

    // generate recipe products form with quantities (recipe page)
    public function buildMyProductsForm(FormBuilderInterface $formBuilder, $recipeProducts, $recipeid){
        foreach($recipeProducts as $key=>$product){
            $formBuilder->add('prod_name_'.$key, 'number', array('label' => $product['name'].' ('.$product['unit'].')', 'data' => $product['quantity']));
        }
        $formBuilder->add('recipe_id', 'hidden', array('label' => 'recipe_id', 'data' => $recipeid));
        $formBuilder->add('recipe_liked', 'checkbox', array('label' => 'Buvo skanu?', 'required' => false));
        $formBuilder->add('save', 'submit', array('label'  => 'Pagaminau', 'attr' => array('class' => 'btn btn-primary btn-md')));
        return $formBuilder->getForm();
    }

    // update 'my_products' products quantities and 'user_recipes' cooked, liked
    public function updateMyProductsAfterCooked($userid, $usedproducts){
        foreach($usedproducts as $key=>$usedproduct){
            if (isset($usedproduct['id'])){
                //update quantity of products that i have
                if($usedproduct['my_product_id']){
//print_r($usedproduct); echo " ";
                    $liked = 0;
                    if (!empty($usedproducts['recipe_liked'])){
                        $liked = 1;
                    }

                    // update product quantity
                    self::updateProductQuantity($usedproduct['my_product_id'], $usedproducts['prod_name_'.$key] );

                    //update users_recipes table, set recipe as cooked and/or liked
                    self::updateUsersRecipes($userid, $usedproducts['recipe_id'], $liked );
                }
            }
        }
    }

    // update product quantity
    public function updateProductQuantity($product_id, $usedQuantity){
        $myproduct = $this->doctrine->getRepository('FrameWorkersTMFoodRescueFoodAppBundle:MyProducts')
            ->findOneById($product_id);

        $oldQuantity  = $myproduct->getQuantity();
        $newQuantity  = $oldQuantity - $usedQuantity;

//echo " old: ".$oldQuantity." used: ".$usedQuantity." new: ".$newQuantity." <br/>";

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

    // update user recipe cooked and/or liked
    public function updateUsersRecipes($userid, $recipeid, $liked=false){
        $userRecipe = $this->doctrine->getRepository('FrameWorkersTMFoodRescueFoodAppBundle:UsersRecipes')
            ->findOneBy(array('usersId' => $userid, 'recipesId' => $recipeid));

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
            }else{
                $userRecipe->setLiked('0');
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