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
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    
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
     * @ORM\ManyToOne(targetEntity="Recipes", inversedBy="products", cascade={"persist"})
     * @ORM\JoinColumn(name="recipe_id", referencedColumnName="id")
     */
    protected $recipe;

    /**
     * @ORM\ManyToOne(targetEntity="Products", inversedBy="recipes", cascade={"persist"})
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
     * Set recipe
     *
     * @param \FrameWorkersTM\FoodRescue\FoodAppBundle\Entity\Recipes $recipe
     * @return RecipesProducts
     */
    public function setRecipe(\FrameWorkersTM\FoodRescue\FoodAppBundle\Entity\Recipes $recipe = null)
    {
        $this->recipe = $recipe;

        return $this;
    }

    /**
     * Get recipe
     *
     * @return \FrameWorkersTM\FoodRescue\FoodAppBundle\Entity\Recipes 
     */
    public function getRecipe()
    {
        return $this->recipe;
    }

    /**
     * Set product
     *
     * @param \FrameWorkersTM\FoodRescue\FoodAppBundle\Entity\Products $product
     * @return RecipesProducts
     */
    public function setProduct(\FrameWorkersTM\FoodRescue\FoodAppBundle\Entity\Products $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \FrameWorkersTM\FoodRescue\FoodAppBundle\Entity\Products 
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
