<?php
/**
 * Created by PhpStorm.
 * User: povlas
 * Date: 4/16/14
 * Time: 9:14 PM
 */

namespace FrameWorkersTM\FoodRescue\FoodAppBundle\Entity;


class Settings {

    protected $userId;
    protected $email;
    protected $notificationTime;
    protected $sortRecipes;

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $notificationDays
     */
    public function setNotificationDays($notificationDays)
    {
        $this->notificationDays = $notificationDays;
    }

    /**
     * @return mixed
     */
    public function getNotificationDays()
    {
        return $this->notificationDays;
    }

    /**
     * @param mixed $recipeSort
     */
    public function setRecipeSort($recipeSort)
    {
        $this->recipeSort = $recipeSort;
    }

    /**
     * @return mixed
     */
    public function getRecipeSort()
    {
        return $this->recipeSort;
    }

    /**
     * @param mixed $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }




} 