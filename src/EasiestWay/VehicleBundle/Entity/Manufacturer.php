<?php

namespace EasiestWay\VehicleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Manufacturer
 */
class Manufacturer
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
     * @var \Doctrine\Common\Collections\Collection
     */
    private $vehicles;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->vehicles = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * @return Manufacturer
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
     * Add vehicles
     *
     * @param \EasiestWay\VehicleBundle\Entity\Vehicle $vehicles
     * @return Manufacturer
     */
    public function addVehicle(\EasiestWay\VehicleBundle\Entity\Vehicle $vehicles)
    {
        $this->vehicles[] = $vehicles;

        return $this;
    }

    /**
     * Remove vehicles
     *
     * @param \EasiestWay\VehicleBundle\Entity\Vehicle $vehicles
     */
    public function removeVehicle(\EasiestWay\VehicleBundle\Entity\Vehicle $vehicles)
    {
        $this->vehicles->removeElement($vehicles);
    }

    /**
     * Get vehicles
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getVehicles()
    {
        return $this->vehicles;
    }

    function __toString() {
        return $this->getTitle();
    }
    /**
     * @var string
     */
    private $country;


    /**
     * Set country
     *
     * @param string $country
     * @return Manufacturer
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string 
     */
    public function getCountry()
    {
        return $this->country;
    }
}
