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
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

/**
 * @ORM\OneToMany(targetEntity="RecipesProducts", mappedBy="recipes")
 */
protected $recipesid;

public function __construct()
{
    $this->recipesid = new ArrayCollection();
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }




    /**
     * Add recipesid
     *
     * @param \FrameWorkersTM\FoodRescue\FoodAppBundle\Entity\RecipesProducts $recipesid
     * @return Recipes
     */
    public function addRecipesid(\FrameWorkersTM\FoodRescue\FoodAppBundle\Entity\RecipesProducts $recipesid)
    {
        $this->recipesid[] = $recipesid;

        return $this;
    }

    /**
     * Remove recipesid
     *
     * @param \FrameWorkersTM\FoodRescue\FoodAppBundle\Entity\RecipesProducts $recipesid
     */
    public function removeRecipesid(\FrameWorkersTM\FoodRescue\FoodAppBundle\Entity\RecipesProducts $recipesid)
    {
        $this->recipesid->removeElement($recipesid);
    }

    /**
     * Get recipesid
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRecipesid()
    {
        return $this->recipesid;
    }

}
