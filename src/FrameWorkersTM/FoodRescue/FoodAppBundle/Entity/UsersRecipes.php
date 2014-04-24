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


}
