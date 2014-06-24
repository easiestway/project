<?php

namespace EasiestWay\VehicleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Volume
 */
class Volume
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $vehicleId;

    /**
     * @var string
     */
    private $title;

    /**
     * @var \EasiestWay\VehicleBundle\Entity\Vehicle
     */
    private $vehicle;

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
     * Set vehicleId
     *
     * @param integer $vehicleId
     * @return Volume
     */
    public function setVehicleId($vehicleId)
    {
        $this->vehicleId = $vehicleId;

        return $this;
    }

    /**
     * Get vehicleId
     *
     * @return integer 
     */
    public function getVehicleId()
    {
        return $this->vehicleId;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Volume
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
     * Set vehicle
     *
     * @param \EasiestWay\VehicleBundle\Entity\Vehicle $vehicle
     * @return Volume
     */
    public function setVehicle(\EasiestWay\VehicleBundle\Entity\Vehicle $vehicle = null)
    {
        $this->vehicle = $vehicle;

        return $this;
    }

    /**
     * Get vehicle
     *
     * @return \EasiestWay\VehicleBundle\Entity\Vehicle 
     */
    public function getVehicle()
    {
        return $this->vehicle;
    }
}
