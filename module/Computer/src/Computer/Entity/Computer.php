<?php

namespace Computer\Entity;

use Doctrine\Common\Collections\ArrayCollection,
    Doctrine\Common\Collections\Collection,
    Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="computers")
 */
class Computer
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
     * @ORM\Column(type="string", length=64)
     */
    protected $serial;    
    
    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=64)
     */
    protected $model;
      
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
     * @var \Computer\Entity\Status
     *
     * @ORM\ManyToOne(targetEntity="Computer\Entity\Status", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="status_id", nullable=true, referencedColumnName="id")
     * })
     */
    protected $status;     
    
    /**
     * @var \Computer\Entity\Category
     *
     * @ORM\ManyToOne(targetEntity="Computer\Entity\Category", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="category_id", nullable=true, referencedColumnName="id")
     * })
     */
    protected $category;      
    
 
    /**
     * Get id
     * 
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Get serial
     * 
     * @return string
     */
    public function getSerial()
    {
        return $this->serial;
    }
    
    /**
     * Set serial
     * 
     * @param string $serial
     * @return \Computer\Entity\Computer
     */
    public function setSerial($serial)
    {
        $this->serial = $serial;

        return $this;
    }        

    /**
     * Get model
     * 
     * @return string
     */
    public function getModel()
    {
        return $this->model;
    }
    
    /**
     * Set model
     * 
     * @param string $model
     * @return \Computer\Entity\Computer
     */
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }    

    


    /**
     * Get createDate
     * 
     * @return \DateTime 
     */
    public function getCreatedDate()
    {
        return $this->createdDate;
    }
    
    /**
     * Set createDate
     * 
     * @param \DateTime $createdDate
     * @return \Computer\Entity\Computer
     */
    public function setCreatedDate(\DateTime $createdDate)
    {
        $this->createdDate = $createdDate;

        return $this;
    }    
    
    /**
     * Get editDate
     * 
     * @return \DateTime 
     */
    public function getEditDate()
    {
        return $this->editDate;
    }    

    /**
     * Set editDate
     * 
     * @param \DateTime $editDate
     * @return \Computer\Entity\Computer
     */
    public function setEditdDate(\DateTime $createdDate)
    {
        $this->editDate = $createdDate;

        return $this;
    }  
    
    /**
     * Set status
     *
     * @param \Computer\Entity\Status
     * @return \Computer\Entity\Computer
     */
    public function setStatus(\Computer\Entity\Status $status = null)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return \Computer\Entity\Status 
     */
    public function getStatus()
    {
        return $this->status;
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
