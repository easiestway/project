<?php

namespace EasiestWay\VehicleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Vehicle
 */
class Vehicle
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
    private $startAt;

    /**
     * @var integer
     */
    private $endAt;

    /**
     * @var integer
     */
    private $type;

    /**
     * @var string
     */
    private $description;

    /**
     * @var integer
     */
    private $manufacturerId;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $volumes;

    /**
     * @var \EasiestWay\VehicleBundle\Entity\Manufacturer
     */
    private $manufacturer;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->volumes = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Vehicle
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
     * Set startAt
     *
     * @param integer $startAt
     * @return Vehicle
     */
    public function setStartAt($startAt)
    {
        $this->startAt = $startAt;

        return $this;
    }

    /**
     * Get startAt
     *
     * @return integer
     */
    public function getStartAt()
    {
        return $this->startAt;
    }

    /**
     * Set endAt
     *
     * @param integer $endAt
     * @return Vehicle
     */
    public function setEndAt($endAt)
    {
        $this->endAt = $endAt;

        return $this;
    }

    /**
     * Get endAt
     *
     * @return integer
     */
    public function getEndAt()
    {
        return $this->endAt;
    }

    /**
     * Set type
     *
     * @param integer $type
     * @return Vehicle
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return integer
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Vehicle
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
     * Set manufacturerId
     *
     * @param integer $manufacturerId
     * @return Vehicle
     */
    public function setManufacturerId($manufacturerId)
    {
        $this->manufacturerId = $manufacturerId;

        return $this;
    }

    /**
     * Get manufacturerId
     *
     * @return integer
     */
    public function getManufacturerId()
    {
        return $this->manufacturerId;
    }

    /**
     * Add volumes
     *
     * @param \EasiestWay\VehicleBundle\Entity\Volume $volumes
     * @return Vehicle
     */
    public function addVolume(\EasiestWay\VehicleBundle\Entity\Volume $volumes)
    {
        $volumes->setVehicle($this);
        $this->volumes[] = $volumes;

        return $this;
    }

    /**
     * Remove volumes
     *
     * @param \EasiestWay\VehicleBundle\Entity\Volume $volumes
     */
    public function removeVolume(\EasiestWay\VehicleBundle\Entity\Volume $volumes)
    {
        $this->volumes->removeElement($volumes);
        $volumes->setVehicle(null);
    }

    /**
     * Get volumes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getVolumes()
    {
        return $this->volumes;
    }

    /**
     * Set manufacturer
     *
     * @param \EasiestWay\VehicleBundle\Entity\Manufacturer $manufacturer
     * @return Vehicle
     */
    public function setManufacturer(\EasiestWay\VehicleBundle\Entity\Manufacturer $manufacturer = null)
    {
        $this->manufacturer = $manufacturer;

        return $this;
    }

    /**
     * Get manufacturer
     *
     * @return \EasiestWay\VehicleBundle\Entity\Manufacturer
     */
    public function getManufacturer()
    {
        return $this->manufacturer;
    }

    public function __toString()
    {
        return $this->getId() ? $this->getName() . ' ' . $this->getYear() : '-';
    }

    public function getShortYear($i)
    {
        return substr($i, 2);
    }

    public function getYear()
    {
        $years = '';
        if ($this->getEndAt()) {
            $years = ' - ' . $this->getShortYear($this->getEndAt());
        }

        if ($this->getStartAt()) {
            $years = $this->getShortYear($this->getStartAt()) . ($years ? $years : ' ->');
        }

        return $years ? "($years)" : '';
    }

    public function getModelName()
    {
        return $this->getTitle() . ' ' . $this->getYear();
    }

    public function getName()
    {
        return $this->getManufacturer()->getTitle() . ' ' . $this->getTitle() . ' ' . $this->getDescription();
    }

}
