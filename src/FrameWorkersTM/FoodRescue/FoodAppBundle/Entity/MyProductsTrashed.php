<?php

namespace FrameWorkersTM\FoodRescue\FoodAppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MyProductsTrashed
 *
 * @ORM\Table(name="my_products_trashed")
 * @ORM\Entity
 */
class MyProductsTrashed
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
     * @var integer
     *
     * @ORM\Column(name="my_product_id", type="integer")
     */
    private $myProductId;

    /**
     * @var string
     *
     * @ORM\Column(name="quantity", type="decimal", precision=45, scale=0, nullable=false)
     */
    private $quantity;






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
     * Set myProductId
     *
     * @param integer $myProductId
     * @return MyProductsTrashed
     */
    public function setMyProductId($myProductId)
    {
        $this->myProductId = $myProductId;

        return $this;
    }

    /**
     * Get myProductId
     *
     * @return integer 
     */
    public function getMyProductId()
    {
        return $this->myProductId;
    }

    /**
     * Set quantity
     *
     * @param string $quantity
     * @return MyProductsTrashed
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
}
