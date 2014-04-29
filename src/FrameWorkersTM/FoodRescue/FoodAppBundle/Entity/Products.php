<?php

namespace FrameWorkersTM\FoodRescue\FoodAppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Products
 *
 * @ORM\Table(name="products", uniqueConstraints={@ORM\UniqueConstraint(name="name", columns={"name"})})
 * @ORM\Entity
 */
class Products
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
     * @ORM\Column(name="price", type="decimal", precision=9, scale=0, nullable=false)
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="quantity", type="decimal", precision=45, scale=0, nullable=false)
     */
    private $quantity;

    /**
     * @var string
     *
     * @ORM\Column(name="unit", type="string", length=45, nullable=false)
     */
    private $unit;

    /**
     * @var integer
     *
     * @ORM\Column(name="end_days", type="integer", nullable=false)
     */
    private $endDays;

    /**
     * @var integer

     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;


    /**
     * @ORM\OneToMany(targetEntity="RecipesProducts", mappedBy="product")
     */
    protected $recipes;

}
