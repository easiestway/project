<?php

namespace Nippon\PartsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DepotProduct
 */
class DepotProduct
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $depotId;

    /**
     * @var integer
     */
    private $productId;

    /**
     * @var integer
     */
    private $quantity;

    /**
     * @var float
     */
    private $price;

    /**
     * @var boolean
     */
    private $isReserved = 0;

    /**
     * @var \DateTime
     */
    private $updatedAt;


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
     * Set depotId
     *
     * @param integer $depotId
     * @return DepotProduct
     */
    public function setDepotId($depotId)
    {
        $this->depotId = $depotId;

        return $this;
    }

    /**
     * Get depotId
     *
     * @return integer 
     */
    public function getDepotId()
    {
        return $this->depotId;
    }

    /**
     * Set productId
     *
     * @param integer $productId
     * @return DepotProduct
     */
    public function setProductId($productId)
    {
        $this->productId = $productId;

        return $this;
    }

    /**
     * Get productId
     *
     * @return integer 
     */
    public function getProductId()
    {
        return $this->productId;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     * @return DepotProduct
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer 
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set price
     *
     * @param float $price
     * @return DepotProduct
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set isReserved
     *
     * @param boolean $isReserved
     * @return DepotProduct
     */
    public function setIsReserved($isReserved)
    {
        $this->isReserved = $isReserved;

        return $this;
    }

    /**
     * Get isReserved
     *
     * @return boolean 
     */
    public function getIsReserved()
    {
        return $this->isReserved;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return DepotProduct
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
    /**
     * @var \Nippon\PartsBundle\Entity\Depot
     */
    private $depot;

    /**
     * @var \Nippon\PartsBundle\Entity\Product
     */
    private $product;


    /**
     * Set depot
     *
     * @param \Nippon\PartsBundle\Entity\Depot $depot
     * @return DepotProduct
     */
    public function setDepot(\Nippon\PartsBundle\Entity\Depot $depot = null)
    {
        $this->depot = $depot;

        return $this;
    }

    /**
     * Get depot
     *
     * @return \Nippon\PartsBundle\Entity\Depot
     */
    public function getDepot()
    {
        return $this->depot;
    }

    /**
     * Set product
     *
     * @param \Nippon\PartsBundle\Entity\Product $product
     * @return DepotProduct
     */
    public function setProduct(\Nippon\PartsBundle\Entity\Product $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \Nippon\PartsBundle\Entity\Product
     */
    public function getProduct()
    {
        return $this->product;
    }
}
