<?php

namespace FrameWorkersTM\FoodRescue\FoodAppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RecipesProducts
 *
 * @ORM\Table(name="recipes_products")
 * @ORM\Entity
 */
class RecipesProducts
{
    /**
     * @var string
     *
     * @ORM\Column(name="quantity", type="decimal", precision=9, scale=2, nullable=false)
     */
    private $quantity;

    /**
     * @var string
     *
     * @ORM\Column(name="unit", type="string", length=255, nullable=false)
     */
    private $unit;

/**
 * @ORM\ManyToOne(targetEntity="Recipes", inversedBy="recipesid")
 * @ORM\JoinColumn(name="recipe_id", referencedColumnName="id")
 */
protected $recipe;

/**
 * @ORM\ManyToOne(targetEntity="Products", inversedBy="recipes")
 * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
 */
protected $product;

    /**
     * Set quantity
     *
     * @param string $quantity
     * @return RecipesProducts
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return string 
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set unit
     *
     * @param string $unit
     * @return RecipesProducts
     */
    public function setUnit($unit)
    {
        $this->unit = $unit;

        return $this;
    }

    /**
     * Get unit
     *
     * @return string 
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * Set recipesId
     *
     * @param integer $recipesId
     * @return RecipesProducts
     */
    public function setRecipesId($recipesId)
    {
        $this->recipesId = $recipesId;

        return $this;
    }

    /**
     * Get recipesId
     *
     * @return integer 
     */
    public function getRecipesId()
    {
        return $this->recipesId;
    }

    /**
     * Set productsId
     *
     * @param integer $productsId
     * @return RecipesProducts
     */
    public function setProductsId($productsId)
    {
        $this->productsId = $productsId;

        return $this;
    }

    /**
     * Get productsId
     *
     * @return integer 
     */
    public function getProductsId()
    {
        return $this->productsId;
    }




    /**
     * Set recipes
     *
     * @param \FrameWorkersTM\FoodRescue\FoodAppBundle\Entity\Recipes $recipes
     * @return RecipesProducts
     */
    public function setRecipes(\FrameWorkersTM\FoodRescue\FoodAppBundle\Entity\Recipes $recipes = null)
    {
        $this->recipes = $recipes;

        return $this;
    }

    /**
     * Get recipes
     *
     * @return \FrameWorkersTM\FoodRescue\FoodAppBundle\Entity\Recipes 
     */
    public function getRecipes()
    {
        return $this->recipes;
    }

    /**
     * Set products
     *
     * @param \FrameWorkersTM\FoodRescue\FoodAppBundle\Entity\Products $products
     * @return RecipesProducts
     */
    public function setProducts(\FrameWorkersTM\FoodRescue\FoodAppBundle\Entity\Products $products = null)
    {
        $this->products = $products;

        return $this;
    }

    /**
     * Get products
     *
     * @return \FrameWorkersTM\FoodRescue\FoodAppBundle\Entity\Products 
     */
    public function getProducts()
    {
        return $this->products;
    }
}
