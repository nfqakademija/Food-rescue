<?php

namespace FrameWorkersTM\FoodRescue\FoodAppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UsersAvailableRecipes
 *
 * @ORM\Table(name="users_available_recipes")
 * @ORM\Entity
 */
class UsersAvailableRecipes
{
    /**
     * @var integer

     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer", nullable=false)
     */
    private $userId;

    /**
     * @var string
     *
     * @ORM\Column(name="recipes_id", type="text", nullable=false)
     */
    private $recipesId;

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
     * Set userId
     *
     * @param integer $userId
     * @return UsersAvailableRecipes
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return integer 
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set recipesId
     *
     * @param string $recipesId
     * @return UsersAvailableRecipes
     */
    public function setRecipesId($recipesId)
    {
        $this->recipesId = $recipesId;

        return $this;
    }

    /**
     * Get recipesId
     *
     * @return string 
     */
    public function getRecipesId()
    {
        return $this->recipesId;
    }
}
