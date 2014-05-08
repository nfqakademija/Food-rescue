<?php
namespace FrameWorkersTM\FoodRescue\FoodAppBundle\Services;

#use FrameWorkersTM\FoodRescue\FoodAppBundle\Entity\Recipes;

class RecipeService
{
    protected $doctrine;

    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /* for testing only */
    public function greet($name)
    {
        //return $this->greeting . ' ' . $name;
        return $name;
    }

    public function findRecipeProducts($recipeid){
        $recipeProducts = $this->doctrine->getRepository('FrameWorkersTMFoodRescueFoodAppBundle:Recipes')
            ->findRecipeProductsNativeSQL($recipeid);
        return $recipeProducts;
    }
}