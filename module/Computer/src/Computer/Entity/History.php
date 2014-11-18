<?php

namespace Computer\Entity;

use Doctrine\Common\Collections\ArrayCollection,
    Doctrine\Common\Collections\Collection,
    Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="computer_history")
 */
class History
{

    /**
     * @var int|null
     *
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var \Computer\Entity\Computer
     *
     * @ORM\ManyToOne(targetEntity="Computer\Entity\Computer", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="computer_id", nullable=true, referencedColumnName="id")
     * })
     */
    protected $computer;  
    
    /**
     * @var \User\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="User\Entity\User", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", nullable=true, referencedColumnName="id")
     * })
     */
    protected $user;      
    
    /**
     * @var int
     *
     * @ORM\Column(type="smallint", options={"unsigned"=true, "default" = 0})
     */
    protected $status;     

    
    /**
     * Get id
     * 
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set computer
     *
     * @param \Computer\Entity\Computer
     * @return \Computer\Entity\History
     */
    public function setComputer(\Computer\Entity\Computer $computer = null)
    {
        $this->computer = $computer;
    
        return $this;
    }

    /**
     * Get computer
     *
     * @return \Computer\Entity\Computer
     */
    public function getComputer()
    {
        return $this->computer;
    } 
    
    /**
     * Set user
     *
     * @param \User\Entity\User
     * @return \Computer\Entity\History
     */
    public function setUser(\User\Entity\User $user = null)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return \User\Entity\User
     */
    public function getUser()
    {
        return $this->user;
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
     * Set status
     * 
     * @param string $name
     * @return \Computer\Entity\Brand
     */
    public function setStatus($status)
    {
        $this->status = $status;
        
        return $this;
    }    
}
