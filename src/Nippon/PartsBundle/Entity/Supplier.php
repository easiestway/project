<?php

namespace Nippon\PartsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Supplier
 */
class Supplier
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
     * @var integer
     */
    private $parentId;

    /**
     * @var boolean
     */
    private $isOriginal = false;

    /**
     * @var string
     */
    private $description = '';


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
     * @return Supplier
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
     * Set parentId
     *
     * @param integer $parentId
     * @return Supplier
     */
    public function setParentId($parentId)
    {
        $this->parentId = $parentId;

        return $this;
    }

    /**
     * Get parentId
     *
     * @return integer 
     */
    public function getParentId()
    {
        return $this->parentId;
    }

    /**
     * Set isOriginal
     *
     * @param boolean $isOriginal
     * @return Supplier
     */
    public function setIsOriginal($isOriginal)
    {
        $this->isOriginal = $isOriginal;

        return $this;
    }

    /**
     * Get isOriginal
     *
     * @return boolean 
     */
    public function getIsOriginal()
    {
        return $this->isOriginal;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Supplier
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $products;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->products = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add products
     *
     * @param \Nippon\PartsBundle\Entity\Product $products
     * @return Supplier
     */
    public function addProduct(\Nippon\PartsBundle\Entity\Product $products)
    {
        $this->products[] = $products;

        return $this;
    }

    /**
     * Remove products
     *
     * @param \Nippon\PartsBundle\Entity\Product $products
     */
    public function removeProduct(\Nippon\PartsBundle\Entity\Product $products)
    {
        $this->products->removeElement($products);
    }

    /**
     * Get products
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProducts()
    {
        return $this->products;
    }
    /**
     * @var \Nippon\PartsBundle\Entity\Supplier
     */
    private $parent;


    /**
     * Set parent
     *
     * @param \Nippon\PartsBundle\Entity\Supplier $parent
     * @return Supplier
     */
    public function setParent(\Nippon\PartsBundle\Entity\Supplier $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \Nippon\PartsBundle\Entity\Supplier
     */
    public function getParent()
    {
        return $this->parent;
    }

    public function __toString() {
      return $this->getTitle();
    }
    /**
     * @var string
     */
    private $canonical;


    /**
     * Set canonical
     *
     * @param string $canonical
     * @return Supplier
     */
    public function setCanonical($canonical)
    {
        $this->canonical = $canonical;

        return $this;
    }

    /**
     * Get canonical
     *
     * @return string 
     */
    public function getCanonical()
    {
        return $this->canonical;
    }
}
