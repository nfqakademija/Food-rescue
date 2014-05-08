<?php

namespace FrameWorkersTM\FoodRescue\FoodAppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Products
 *
 * @ORM\Table(name="products", uniqueConstraints={@ORM\UniqueConstraint(name="name", columns={"name"})})
 * @ORM\Entity
 */
class Products
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *
     */
    private $id;
     /**
      *
      *  @ORM\OneToMany(targetEntity="MyProducts", mappedBy="products")
      *
      */
    protected $myProducts;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="decimal", precision=9, scale=0, nullable=false)
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="quantity", type="decimal", precision=45, scale=0, nullable=false)
     */
    private $quantity;

    /**
     * @var string
     *
     * @ORM\Column(name="unit", type="string", length=45, nullable=false)
     */
    private $unit;

    /**
     * @var integer
     *
     * @ORM\Column(name="end_days", type="integer", nullable=false)
     */
    private $endDays;



    /**
     * @ORM\OneToMany(targetEntity="RecipesProducts", mappedBy="product")
     */
    protected $recipes;

    /**
     * @ORM\OneToMany(targetEntity="MyProducts", mappedBy="product")
     */
    protected $products;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->recipes = new \Doctrine\Common\Collections\ArrayCollection();
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

    /**
     * Set name
     *
     * @param string $name
     * @return Products
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set price
     *
     * @param string $price
     * @return Products
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set quantity
     *
     * @param string $quantity
     * @return Products
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
     * @return Products
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
     * Set endDays
     *
     * @param integer $endDays
     * @return Products
     */
    public function setEndDays($endDays)
    {
        $this->endDays = $endDays;

        return $this;
    }

    /**
     * Get endDays
     *
     * @return integer 
     */
    public function getEndDays()
    {
        return $this->endDays;
    }

    /**
     * Add recipes
     *
     * @param \FrameWorkersTM\FoodRescue\FoodAppBundle\Entity\RecipesProducts $recipes
     * @return Products
     */
    public function addRecipe(\FrameWorkersTM\FoodRescue\FoodAppBundle\Entity\RecipesProducts $recipes)
    {
        $this->recipes[] = $recipes;

        return $this;
    }

    /**
     * Remove recipes
     *
     * @param \FrameWorkersTM\FoodRescue\FoodAppBundle\Entity\RecipesProducts $recipes
     */
    public function removeRecipe(\FrameWorkersTM\FoodRescue\FoodAppBundle\Entity\RecipesProducts $recipes)
    {
        $this->recipes->removeElement($recipes);
    }

    /**
     * Get recipes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRecipes()
    {
        return $this->recipes;
    }

    /**
     * Add product
     *
     * @param \FrameWorkersTM\FoodRescue\FoodAppBundle\Entity\MyProducts $product
     * @return Products
     */
    public function addProduct(\FrameWorkersTM\FoodRescue\FoodAppBundle\Entity\MyProducts $product)
    {
        $this->product[] = $product;

        return $this;
    }

    /**
     * Remove product
     *
     * @param \FrameWorkersTM\FoodRescue\FoodAppBundle\Entity\MyProducts $product
     */
    public function removeProduct(\FrameWorkersTM\FoodRescue\FoodAppBundle\Entity\MyProducts $product)
    {
        $this->product->removeElement($product);
    }

    /**
     * Get product
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Get products
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProducts()
    {
        return $this->products;
    }
}
