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
     * @var string
     *
     * @ORM\Column(name="quantity", type="decimal", precision=45, scale=0, nullable=false)
     */
    private $quantity;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="my_products_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $myProductsId;


}
