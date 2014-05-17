<?php

namespace FrameWorkersTM\FoodRescue\FoodAppBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;

/**
 * RecipesRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class RecipesRepository extends EntityRepository
{

    // get recipes by user products
    public function findRecipesByUserNativeSQL($userid, $quantity, $limit = null)
    {
        if (!empty($limit)){
            //5,10;  # Retrieve rows 6-15
            //5 # Retrieve firs 5 rows
            $limitblock = $limit;
        }
        else{
            $limitblock = '15';
        }

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

    // get recipe with info if it was cooked and liked
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

    // get recipe products with quantity required and products nr i have for recipe
    public function findRecipeProductsNativeSQL($userid, $recipeid)
    {
        $em = $this->getEntityManager();
        $connection = $em->getConnection();
        $statement = $connection->prepare("
                 SELECT a.id, a.name, a.unit, b.quantity, d.id as my_product_id
                 FROM products a
                 LEFT JOIN recipes_products b on b.product_id = a.id
                 LEFT JOIN my_products d on d.product_id = a.id AND d.user_id = :user_id
                 WHERE b.recipe_id = :recipe_id
                 ;
        ");
        $statement->bindValue('recipe_id', $recipeid);
        $statement->bindValue('user_id', $userid);
        $statement->execute();
        $results = $statement->fetchAll();
        return $results;
    }
}
