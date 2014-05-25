<?php

namespace FrameWorkersTM\FoodRescue\FoodAppBundle\Entity;

use Doctrine\ORM\EntityRepository;
#use Doctrine\ORM\Query\ResultSetMapping;

/**
 * RecipesRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class RecipesRepository extends EntityRepository
{

    // move demo user products to registered user
    public function addNewUserProductsFromDemoNativeSQL($userid,$guestid){
        $em = $this->getEntityManager();
        $connection = $em->getConnection();
        $statement = $connection->prepare("
            UPDATE my_products
            SET user_id = :userid
            WHERE user_id = :guestid
        ");
        $statement->bindValue('userid', $userid);
        $statement->bindValue('guestid', $guestid);
        $statement->execute();
    }

    // get trashed products and write them to trashed products table
    public function findTrashedProductsNativeSQL($userid){
        $em = $this->getEntityManager();
        $connection = $em->getConnection();
        $statement = $connection->prepare("
            SELECT product_id, quantity
            FROM my_products
            WHERE end_date < UNIX_TIMESTAMP(NOW()) AND user_id = :userid
        ");
        $statement->bindValue('userid', $userid);
        $statement->execute();
        $results = $statement->fetchAll();
        return $results;
    }

    // get user products that will end soon
    public function findUserProductsIds($userid){
        //paimam pirmus 10 produktu.
        $em = $this->getEntityManager();
        $connection = $em->getConnection();
        $statement = $connection->prepare("
            SELECT product_id,end_date
            FROM my_products
            WHERE user_id =:userid
            ORDER BY end_date ASC
            LIMIT 10
        ;
        ");
        $statement->bindValue('userid', $userid);
        $statement->execute();
        $myproducts = $statement->fetchAll();

        if (!$myproducts){return;}
        $cc = count($myproducts);
        $firstDayOrigin = $myproducts['0']['end_date'];
        $lastDayOrigin = $myproducts[$cc-1]['end_date'];
        $firstDay= date('Y/m/d',$firstDayOrigin);
        $lastDay = date('Y/m/d',$lastDayOrigin);
echo $cc."<br/>";
echo $firstDay."<br/>";
echo $lastDay."<br/>";
        //randam dienu skirtuma tarp 1mo ir paskutinio produkto
        $firstDay = strtotime($firstDay);
        $lastDay = strtotime($lastDay);

        $datediff = $lastDay - $firstDay;
        $daysDiff = floor($datediff/(60*60*24));

echo $daysDiff." days difference<br/>";

        //if end date difference between 10 products is more than 3 days,
        //then get all products ids till last known end date
        //otherwise get all products ids from  up to 3 days after first end date


        if ($daysDiff > 3 ){
            //print_r($myproducts);
           // return $myproducts;
echo " > <br/>";
            $statement = $connection->prepare("
                SELECT product_id
                FROM my_products
                WHERE user_id =:userid
                AND end_date <= :lastday
                ORDER BY end_date ASC
            ;
            ");
            $statement->bindValue('userid', $userid);
            $statement->bindValue('lastday', $lastDayOrigin);
            $statement->execute();
            $results= $statement->fetchAll();

 //print_r($results);
            return $results;
        }else{
echo " < <br/>";
            $statement = $connection->prepare("
                SELECT product_id
                FROM my_products
                WHERE user_id =:userid
                AND end_date <= :firstday + 60 * 60 * 24 * 3
                ORDER BY end_date ASC
            ;
            ");
            $statement->bindValue('userid', $userid);
            $statement->bindValue('firstday', $firstDayOrigin);
            $statement->execute();
            $results= $statement->fetchAll();

 //print_r($results);
            return $results;
        }

    }

    // get recipes, when a user have minimum half products for them.
    public function findAvailableUserRecipesNativeSQL($userid, $quantity)
    {

        // find my products
        /*
        $em = $this->getEntityManager();
        $connection = $em->getConnection();
        $statement = $connection->prepare("SELECT product_id FROM my_products WHERE user_id = :userid;");
        $statement->bindValue('userid', $userid);
        $statement->execute();
        $myproducts = $statement->fetchAll();
        */
        // find my products
        $myproducts = self::findUserProductsIds($userid);


        //if user have no product return false
        if (!$myproducts){ return; }

        //else prepare my products for query
        $temp = array();
        foreach($myproducts as $key=>$myproduct){
            $temp[$key] = $myproduct['product_id'];
        }

        $myProdsIds = implode(',',$temp);

//echo "My productsz:<br/>";
print_r($myProdsIds);
        $em = $this->getEntityManager();
        $connection = $em->getConnection();
        $statement = $connection->prepare("
             SELECT a.id, a.name, a.image_name, a.products_nr,
             (  SELECT COUNT(e.product_id)
                 FROM recipes_products e
                 WHERE e.product_id in (".$myProdsIds.")
                 AND e.recipe_id = a.id
             ) as products_accepted,
             f.cooked, f.liked

             FROM recipes as a
             LEFT JOIN users_recipes f on f.user_id = :userid AND f.recipe_id = a.id

             WHERE (SELECT COUNT(e.product_id)
                 FROM recipes_products e
                 WHERE e.product_id in (".$myProdsIds.")
                 AND e.recipe_id = a.id
                 ) >= a.products_nr/:quantity

             ORDER BY a.id ASC
             LIMIT 45
             ;
        ");
        $statement->bindValue('quantity', $quantity);
        $statement->bindValue('userid', $userid);
        $statement->execute();
        $results = $statement->fetchAll();
        return $results;
    }

    // DEPRECATED - get recipes (realtime calculation - not effective) (recipes page)
    public function findRecipesByUserNativeSQL($userid, $quantity, $limit = null)
    {

        $limitblock = (!empty($limit) ? $limit : 15);

        $em = $this->getEntityManager();
        $connection = $em->getConnection();
        $statement = $connection->prepare("
             SELECT DISTINCT(a.id), a.name, a.image_name, a.products_nr,
             (  SELECT COUNT(e.product_id)
                 FROM recipes_products e
                 WHERE e.product_id in (SELECT product_id FROM my_products WHERE user_id = :userid)
                 AND e.recipe_id = a.id
             ) as products_accepted,
             f.cooked, f.liked

             FROM recipes as a
             LEFT JOIN recipes_products as b ON b.recipe_id = a.id
             LEFT JOIN products as d ON d.id = b.product_id
             LEFT JOIN users_recipes f on f.user_id = :userid AND f.recipe_id = a.id

             WHERE (SELECT COUNT(e.product_id)
                 FROM recipes_products e
                 WHERE e.product_id in (SELECT product_id FROM my_products WHERE user_id = :userid)
                 AND e.recipe_id = a.id
                 ) >= a.products_nr/:quantity

             ORDER BY a.id ASC
             LIMIT ".$limitblock."
             ;
        ");
        $statement->bindValue('quantity', $quantity);
        $statement->bindValue('userid', $userid);
        $statement->execute();
        $results = $statement->fetchAll();
        return $results;
    }

    // get recipe with info if it was cooked and liked (recipe page)
    public function findRecipeNativeSQL($userid, $recipeid)
    {
        $em = $this->getEntityManager();
        $connection = $em->getConnection();
        $statement = $connection->prepare("
             SELECT a.id, a.name, a.describtion, a.image_name, a.products_nr,
             b.cooked, b.liked
             FROM recipes a
             LEFT JOIN users_recipes b ON b.user_id = :user_id AND b.recipe_id = :recipe_id
             WHERE a.id = :recipe_id
             ;
        ");
        $statement->bindValue('user_id', $userid);
        $statement->bindValue('recipe_id', $recipeid);
        $statement->execute();
        $results = $statement->fetch();
        return $results;
    }

    // get recipe products with quantity required and products nr i have for recipe (recipe page)
    public function findRecipeProductsNativeSQL($userid, $recipeid)
    {
        $em = $this->getEntityManager();
        $connection = $em->getConnection();
        $statement= $connection->prepare("
             SELECT a.id, a.name, a.unit, b.quantity, d.id as my_product_id
             FROM products a
             LEFT JOIN recipes_products b on b.product_id = a.id
             LEFT JOIN my_products d on d.product_id = a.id AND d.user_id = :user_id
             WHERE b.recipe_id = :recipe_id
             ORDER BY a.id ASC
             ;
        ");
        $statement->bindValue('recipe_id', $recipeid);
        $statement->bindValue('user_id', $userid);
        $statement->execute();
        $result = $statement->fetchAll();
        return $result;
    }

}
