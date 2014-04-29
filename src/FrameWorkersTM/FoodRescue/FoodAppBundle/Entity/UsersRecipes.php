<?php

namespace FrameWorkersTM\FoodRescue\FoodAppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UsersRecipes
 *
 * @ORM\Table(name="users_recipes")
 * @ORM\Entity
 */
class UsersRecipes
{
    /**
     * @var integer
     *
     * @ORM\Column(name="cooked", type="integer", nullable=false)
     */
    private $cooked;

    /**
     * @var integer
     *
     * @ORM\Column(name="liked", type="integer", nullable=false)
     */
    private $liked;

    /**
     * @var integer
     *
     * @ORM\Column(name="users_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $usersId;

    /**
     * @var integer
     *
     * @ORM\Column(name="recipes_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $recipesId;



    /**
     * Set cooked
     *
     * @param integer $cooked
     * @return UsersRecipes
     */
    public function setCooked($cooked)
    {
        $this->cooked = $cooked;

        return $this;
    }

    /**
     * Get cooked
     *
     * @return integer 
     */
    public function getCooked()
    {
        return $this->cooked;
    }

    /**
     * Set liked
     *
     * @param integer $liked
     * @return UsersRecipes
     */
    public function setLiked($liked)
    {
        $this->liked = $liked;

        return $this;
    }

    /**
     * Get liked
     *
     * @return integer 
     */
    public function getLiked()
    {
        return $this->liked;
    }

    /**
     * Set usersId
     *
     * @param integer $usersId
     * @return UsersRecipes
     */
    public function setUsersId($usersId)
    {
        $this->usersId = $usersId;

        return $this;
    }

    /**
     * Get usersId
     *
     * @return integer 
     */
    public function getUsersId()
    {
        return $this->usersId;
    }

    /**
     * Set recipesId
     *
     * @param integer $recipesId
     * @return UsersRecipes
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
}
