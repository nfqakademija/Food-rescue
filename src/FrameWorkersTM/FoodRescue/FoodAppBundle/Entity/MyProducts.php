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
     * @var Products
     *
     * @ORM\ManyToOne(targetEntity="Products", inversedBy="products")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     *
     */
    private $product;



    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer")
     */
    private $userId;

    /**
     * var integer
     *
     * ORM\Column(name="product_id", type="integer")

    private $productId;
     */


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
     * @return MyProducts
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
     * Set product
     *
     * @param \FrameWorkersTM\FoodRescue\FoodAppBundle\Entity\Products $product
     * @return MyProducts
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
}
