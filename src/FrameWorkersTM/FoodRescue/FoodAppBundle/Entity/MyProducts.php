<?php

namespace FrameWorkersTM\FoodRescue\FoodAppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MyProducts
 *
 * @ORM\Table(name="my_products")
 * @ORM\Entity
 */
class MyProducts
{
    /**
     * @var string
     *
     * @ORM\Column(name="quantity", type="decimal", precision=45, scale=0, nullable=false)
     */
    private $quantity;

    /**
     * @var integer
     *
     * @ORM\Column(name="end_date", type="integer", nullable=false)
     */
    private $endDate;

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
     * @ORM\Column(name="products_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $productsId;



    /**
     * Set quantity
     *
     * @param string $quantity
     * @return MyProducts
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
     * Set endDate
     *
     * @param integer $endDate
     * @return MyProducts
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get endDate
     *
     * @return integer 
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Set usersId
     *
     * @param integer $usersId
     * @return MyProducts
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
     * Set productsId
     *
     * @param integer $productsId
     * @return MyProducts
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
