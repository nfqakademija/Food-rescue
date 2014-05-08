<?php

namespace FrameWorkersTM\FoodRescue\FoodAppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Recipes
 *
 * @ORM\Table(name="recipes")
 * @ORM\Entity(repositoryClass="FrameWorkersTM\FoodRescue\FoodAppBundle\Entity\RecipesRepository")
 */
class Recipes
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
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="describtion", type="text", nullable=false)
     */
    private $describtion;

    /**
     * @var string
     *
     * @ORM\Column(name="image_name", type="string", length=255, nullable=false)
     */
    private $imageName;

    /**
     * @var integer
     *
     * @ORM\Column(name="products_nr", type="integer", nullable=false)
     */
    private $productsNr;

    /**
     * @ORM\OneToMany(targetEntity="RecipesProducts", mappedBy="recipe")
     */
    protected $products;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->products = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Recipes
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
     * Set describtion
     *
     * @param string $describtion
     * @return Recipes
     */
    public function setDescribtion($describtion)
    {
        $this->describtion = $describtion;

        return $this;
    }

    /**
     * Get describtion
     *
     * @return string 
     */
    public function getDescribtion()
    {
        return $this->describtion;
    }

    /**
     * Set imageName
     *
     * @param string $imageName
     * @return Recipes
     */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;

        return $this;
    }

    /**
     * Get imageName
     *
     * @return string 
     */
    public function getImageName()
    {
        return $this->imageName;
    }

    /**
     * Set productsNr
     *
     * @param integer $productsNr
     * @return Recipes
     */
    public function setProductsNr($productsNr)
    {
        $this->productsNr = $productsNr;

        return $this;
    }

    /**
     * Get productsNr
     *
     * @return integer 
     */
    public function getProductsNr()
    {
        return $this->productsNr;
    }

    /**
     * Add products
     *
     * @param \FrameWorkersTM\FoodRescue\FoodAppBundle\Entity\RecipesProducts $products
     * @return Recipes
     */
    public function addProduct(\FrameWorkersTM\FoodRescue\FoodAppBundle\Entity\RecipesProducts $products)
    {
        $this->products[] = $products;

        return $this;
    }

    /**
     * Remove products
     *
     * @param \FrameWorkersTM\FoodRescue\FoodAppBundle\Entity\RecipesProducts $products
     */
    public function removeProduct(\FrameWorkersTM\FoodRescue\FoodAppBundle\Entity\RecipesProducts $products)
    {
        $this->products->removeElement($products);
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
