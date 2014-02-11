<?php

namespace Nippon\PartsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Depot
 */
class Depot
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $userTitle;

    /**
     * @var string
     */
    private $currency;

    /**
     * @var string
     */
    private $delivery;

    /**
     * @var string
     */
    private $delivery2;

    /**
     * @var integer
     */
    private $price1Index = 1.5;

    /**
     * @var integer
     */
    private $price2Index = 1.4;

    /**
     * @var integer
     */
    private $price3Index = 1.3;

    /**
     * @var boolean
     */
    private $isActive;

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
     * Set title
     *
     * @param string $title
     * @return Depot
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set userTitle
     *
     * @param string $userTitle
     * @return Depot
     */
    public function setUserTitle($userTitle)
    {
        $this->userTitle = $userTitle;

        return $this;
    }

    /**
     * Get userTitle
     *
     * @return string 
     */
    public function getUserTitle()
    {
        return $this->userTitle;
    }

    /**
     * Set currency
     *
     * @param string $currency
     * @return Depot
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * Get currency
     *
     * @return string 
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Set delivery
     *
     * @param string $delivery
     * @return Depot
     */
    public function setDelivery($delivery)
    {
        $this->delivery = $delivery;

        return $this;
    }

    /**
     * Get delivery
     *
     * @return string 
     */
    public function getDelivery()
    {
        return $this->delivery;
    }

    /**
     * Set delivery2
     *
     * @param string $delivery2
     * @return Depot
     */
    public function setDelivery2($delivery2)
    {
        $this->delivery2 = $delivery2;

        return $this;
    }

    /**
     * Get delivery2
     *
     * @return string 
     */
    public function getDelivery2()
    {
        return $this->delivery2;
    }

    /**
     * Set price1Index
     *
     * @param integer $price1Index
     * @return Depot
     */
    public function setPrice1Index($price1Index)
    {
        $this->price1Index = $price1Index;

        return $this;
    }

    /**
     * Get price1Index
     *
     * @return integer 
     */
    public function getPrice1Index()
    {
        return $this->price1Index;
    }

    /**
     * Set price2Index
     *
     * @param integer $price2Index
     * @return Depot
     */
    public function setPrice2Index($price2Index)
    {
        $this->price2Index = $price2Index;

        return $this;
    }

    /**
     * Get price2Index
     *
     * @return integer 
     */
    public function getPrice2Index()
    {
        return $this->price2Index;
    }

    /**
     * Set price3Index
     *
     * @param integer $price3Index
     * @return Depot
     */
    public function setPrice3Index($price3Index)
    {
        $this->price3Index = $price3Index;

        return $this;
    }

    /**
     * Get price3Index
     *
     * @return integer 
     */
    public function getPrice3Index()
    {
        return $this->price3Index;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return Depot
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean 
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Depot
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
     * @var \Doctrine\Common\Collections\Collection
     */
    private $depot_products;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->depot_products = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add depot_products
     *
     * @param \Nippon\PartsBundle\Entity\DepotProduct $depotProducts
     * @return Depot
     */
    public function addDepotProduct(\Nippon\PartsBundle\Entity\DepotProduct $depotProducts)
    {
        $this->depot_products[] = $depotProducts;

        return $this;
    }

    /**
     * Remove depot_products
     *
     * @param \Nippon\PartsBundle\Entity\DepotProduct $depotProducts
     */
    public function removeDepotProduct(\Nippon\PartsBundle\Entity\DepotProduct $depotProducts)
    {
        $this->depot_products->removeElement($depotProducts);
    }

    /**
     * Get depot_products
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDepotProducts()
    {
        return $this->depot_products;
    }

    public function __toString() {
        return $this->getTitle();
    }
}
