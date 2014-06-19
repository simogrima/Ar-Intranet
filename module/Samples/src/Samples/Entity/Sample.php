<?php

namespace Samples\Entity;

use Doctrine\Common\Collections\ArrayCollection,
    Doctrine\Common\Collections\Collection,
    Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="samples")
 */
class Sample
{

    /**
     * @var int|null
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=128)
     */
    protected $model;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=128)
     */
    protected $voltage; //tensione

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=128)
     */
    protected $plug; //spina

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=128)
     */
    protected $frequency; //frequenza

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=128)
     */
    protected $serigraphy; //serigrafia

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=128)
     */
    protected $colors; //frequenza

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=128)
     */
    protected $cable; //frequenza

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=128)
     */
    protected $accessories = 'Standard'; //accessori  

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_date", type="datetime", nullable=false)
     */
    protected $createdDate;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="edit_date", type="datetime", nullable=false)
     */
    protected $editDate;
    

    /**
     * Getter id
     * 
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Getter model
     * 
     * @return string
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Getter voltage
     * 
     * @return string
     */
    public function getVoltage()
    {
        return $this->voltage;
    }

    /**
     * Getter plug
     * 
     * @return string
     */
    public function getPlug()
    {
        return $this->plug;
    }

    /**
     * Getter frequency
     * 
     * @return string
     */
    public function getFrequency()
    {
        return $this->frequency;
    }

    /**
     * Getter serigraphy
     * 
     * @return string
     */
    public function getSerigraphy()
    {
        return $this->serigraphy;
    }

    /**
     * Getter colors
     * 
     * @return string
     */
    public function getColors()
    {
        return $this->colors;
    }

    /**
     * Getter cable
     * 
     * @return string
     */
    public function getCable()
    {
        return $this->cable;
    }

    /**
     * Getter accessories
     * 
     * @return string
     */
    public function getAccessories()
    {
        return $this->accessories;
    }

    /**
     * Getter createDate
     * 
     * @return \DateTime 
     */
    public function getCreatedDate()
    {
        return $this->createdDate;
    }
    
    /**
     * Getter editDate
     * 
     * @return \DateTime 
     */
    public function getEditDate()
    {
        return $this->editDate;
    }    

    /**
     * Setter model
     * 
     * @param string $model
     * @return \Samples\Entity\Sample
     */
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Setter voltage
     * 
     * @param string $voltage
     * @return \Samples\Entity\Sample
     */
    public function setVoltage($voltage)
    {
        $this->voltage = $voltage;

        return $this;
    }

    /**
     * Setter plug
     * 
     * @param string $plug
     * @return \Samples\Entity\Sample
     */
    public function setPlug($plug)
    {
        $this->plug = $plug;

        return $this;
    }

    /**
     * Setter frequency
     * 
     * @param string $frequency
     * @return \Samples\Entity\Sample
     */
    public function setFrequency($frequency)
    {
        $this->frequency = $frequency;

        return $this;
    }

    /**
     * Setter serigraphy
     * 
     * @param string $serigraphy
     * @return \Samples\Entity\Sample
     */
    public function setSerigraphy($serigraphy)
    {
        $this->serigraphy = $serigraphy;

        return $this;
    }

    /**
     * Setter colors
     * 
     * @param string $colors
     * @return \Samples\Entity\Sample
     */
    public function setColors($colors)
    {
        $this->colors = $colors;

        return $this;
    }

    /**
     * Setter cable
     * 
     * @param string $cable
     * @return \Samples\Entity\Sample
     */
    public function setCable($cable)
    {
        $this->cable = $cable;

        return $this;
    }

    /**
     * Setter accessories
     * 
     * @param string $accessories
     * @return \Samples\Entity\Sample
     */
    public function setAccessories($accessories)
    {
        $this->accessories = $accessories;

        return $this;
    }

    /**
     * Setter createDate
     * 
     * @param \DateTime $createdDate
     * @return \Samples\Entity\Sample
     */
    public function setCreatedDate(\DateTime $createdDate)
    {
        $this->createdDate = $createdDate;

        return $this;
    }
    
    /**
     * Setter editDate
     * 
     * @param \DateTime $editDate
     * @return \Samples\Entity\Sample
     */
    public function setEditdDate(\DateTime $createdDate)
    {
        $this->editDate = $createdDate;

        return $this;
    }    

    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {

        if (empty($this->getCreatedDate())) {
            $this->setCreatedDate(new \Datetime());
        }
    
        $this->setEditdDate(new \Datetime());

    }
    
    


}
