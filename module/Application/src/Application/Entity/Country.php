<?php

namespace Application\Entity;

use Doctrine\Common\Collections\ArrayCollection,
    Doctrine\Common\Collections\Collection,
    Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="country")
 */
class Country
{

    /**
     * @var int|null
     *
     * @ORM\Id
     * @ORM\Column(name="country_id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $countryId;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=128)
     */
    protected $name;

    /**
     * @var string|null
     *
     * @ORM\Column(name="iso_code_2", type="string", length=128)
     */
    protected $isoCode2;

    /**
     * @var string|null
     *
     * @ORM\Column(name="iso_code_3", type="string", length=128)
     */
    protected $isoCode3;

    /**
     * @var int
     *
     * @ORM\Column(name="postcode_required", type="smallint", options={"unsigned"=true, "default" = 0})
     */
    protected $postcodeRequired; 

    /**
     * @var int
     *
     * @ORM\Column(type="smallint", options={"unsigned"=true, "default" = 0})
     */
    protected $status; 
    
    /**
     * Get countryId
     * 
     * @return int
     */
    public function getCountryId()
    {
        return $this->countryId;
    }

    /**
     * Get name
     * 
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get isoCode2
     * 
     * @return string
     */
    public function getIsoCode2()
    {
        return $this->isoCode2;
    }
    
    /**
     * Get isoCode3
     * 
     * @return string
     */
    public function getIsoCode3()
    {
        return $this->isoCode3;
    }

    /**
     * Get postcodeRequired
     * 
     * @return int
     */
    public function getPostcodeRequired()
    {
        return $this->postcodeRequired;
    }

    /**
     * Get status
     * 
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set name
     * 
     * @param string $name
     * @return \Application\Country\Country
     */
    public function setName($name)
    {
        $this->name = $name;
        
        return $this;
    }

    /**
     * Set isoCode2
     * 
     * @param string $isoCode2
     * @return \Application\Country\Country
     */
    public function setIsoCode2($isoCode2)
    {
        $this->isoCode2 = $isoCode2;
        
        return $this;
    }

    /**
     * Set isoCode3
     * 
     * @param string $isoCode3
     * @return \Application\Country\Country
     */
    public function setIsoCode3($isoCode3)
    {
        $this->isoCode3 = $isoCode3;
        
        return $this;
    }

    /**
     * Set postcodeRequired
     * 
     * @param int $postcodeRequired
     * @return \Application\Country\Country
     */
    public function setPostcodeRequired($postcodeRequired)
    {
        $this->postcodeRequired = $postcodeRequired;
        
        return $this;
    }

    /**
     * Set status
     * 
     * @param int $status
     * @return \Application\Country\Country
     */
    public function setStatus($status)
    {
        $this->status = $status;
        
        return $this;
    }



}
