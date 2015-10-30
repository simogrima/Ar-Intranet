<?php

namespace Application\Entity;

use Doctrine\Common\Collections\ArrayCollection,
    Doctrine\Common\Collections\Collection,
    Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="family")
 */
class Family
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
    protected $name;


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
     * Get name
     * 
     * @return string
     */
    public function getName()
    {
        return $this->name;
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
     * @return \Application\Entity\Family
     */
    public function setName($name)
    {
        $this->name = $name;
        
        return $this;
    }

    /**
     * Set status
     * 
     * @param int $status
     * @return \Application\Entity\Family
     */
    public function setStatus($status)
    {
        $this->status = $status;
        
        return $this;
    }



}
