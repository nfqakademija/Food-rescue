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
     * @var integer
     *
     * @ORM\Column(name="recipes_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $recipesId;

    /**
     * @var integer
     *
     * @ORM\Column(name="products_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $productsId;



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
}
