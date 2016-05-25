<?php

namespace Application\Entity;

use Doctrine\Common\Collections\ArrayCollection,
    Doctrine\Common\Collections\Collection,
    Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="supplier")
 */
class Supplier
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
     * @ORM\Column(name="company_name", type="string", length=128)
     */
    protected $companyName;


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
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get companyName
     * 
     * @return string
     */
    public function getCompanyName()
    {
        return $this->companyName;
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
     * Set companyName
     * 
     * @param string $companyName
     * @return \Application\Entity\Supplier
     */
    public function setCompanyName($companyName)
    {
        $this->companyName = $companyName;
        
        return $this;
    }

    /**
     * Set status
     * 
     * @param int $status
     * @return \Application\Entity\Supplier
     */
    public function setStatus($status)
    {
        $this->status = $status;
        
        return $this;
    }



}
