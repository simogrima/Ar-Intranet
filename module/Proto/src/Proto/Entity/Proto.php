<?php

namespace Prototyping\Entity;

use Doctrine\Common\Collections\ArrayCollection,
    Doctrine\Common\Collections\Collection,
    Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="prototyping")
 */
class Prototyping
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
     * @ORM\Column(name="project_code", type="string", length=128)
     */
    protected $projectCode;
    
    /**
     * @var string|null
     *
     * @ORM\Column(name="product_code", type="string", nullable=true, length=128)
     */
    protected $productCode;    
    
    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $description;   
    
    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true, length=128)
     */
    protected $destination;     
    
    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true, length=128)
     */
    protected $customer;    
                    
    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true, length=128)
     */
    protected $voltage; //tensione

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true, length=128)
     */
    protected $frequency; //frequenza
    
    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true, length=128)
     */
    protected $absorption; //assorbimento    
    
    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true, length=128)
     */
    protected $pressure; //pressione     
    
    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true, length=128)
     */
    protected $progress; //avanzamento    
    

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_date", type="datetime", nullable=false)
     */
    protected $createdDate;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_date", type="datetime", nullable=true)
     */
    protected $endDate;    
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="edit_date", type="datetime", nullable=false)
     */
    protected $editDate;
    
    /**
     * @ORM\OneToMany(targetEntity="Prototyping\Entity\Attachments", mappedBy="prototyping", cascade={"remove"})
     */
    protected $attachments;   
    
    /**
     * @ORM\OneToMany(targetEntity="Prototyping\Entity\History", mappedBy="prototyping", cascade={"remove"})
     */
    protected $history;      
    
    /**
     * @var \Prototyping\Entity\Status
     *
     * @ORM\ManyToOne(targetEntity="Prototyping\Entity\Status", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="status_id", nullable=true, referencedColumnName="id")
     * })
     */
    protected $status;       
    
    /**
     * @var \Application\Entity\Family
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\Family", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="family_id", nullable=true, referencedColumnName="id")
     * })
     */
    protected $family;         
    
    /**
     * Never forget to initialize all your collections !
     */
    public function __construct()
    {
        $this->attachments = new ArrayCollection();
        $this->history = new ArrayCollection();
    }      
    
 
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
     * Get projectCode
     * 
     * @return string
     */
    public function getProjectCode()
    {
        return $this->projectCode;
    }
    
    /**
     * Set projectCode
     * 
     * @param string $projectCode
     * @return \Prototyping\Entity\Prototyping
     */
    public function setProjectCode($projectCode)
    {
        $this->projectCode = $projectCode;

        return $this;
    }   
    
    /**
     * Get productCode
     * 
     * @return string
     */
    public function getProductCode()
    {
        return $this->productCode;
    }
    
    /**
     * Set productCode
     * 
     * @param string $productCode
     * @return \Prototyping\Entity\Prototyping
     */
    public function setProductCode($productCode)
    {
        $this->productCode = $productCode;

        return $this;
    }     
    
    /**
     * Get customer
     * 
     * @return string
     */
    public function getCustomer()
    {
        return $this->customer;
    }    
        
    /**
     * Set customer
     * 
     * @param string $customer
     * @return \Prototyping\Entity\Prototyping
     */
    public function setCustomer($customer)
    {
        $this->customer = $customer;

        return $this;
    }          

    /**
     * Get voltage
     * 
     * @return string
     */
    public function getVoltage()
    {
        return $this->voltage;
    }
    
    /**
     * Set voltage
     * 
     * @param string $voltage
     * @return \Prototyping\Entity\Prototyping
     */
    public function setVoltage($voltage)
    {
        $this->voltage = $voltage;

        return $this;
    }    

    /**
     * Get frequency
     * 
     * @return string
     */
    public function getFrequency()
    {
        return $this->frequency;
    }
    
    /**
     * Set frequency
     * 
     * @param string $frequency
     * @return \Prototyping\Entity\Prototyping
     */
    public function setFrequency($frequency)
    {
        $this->frequency = $frequency;

        return $this;
    }        
    
    /**
     * Get absorption
     * 
     * @return string
     */       
    public function getAbsorption()
    {
        return $this->absorption;
    } 

    /**
     * Set absorption
     * 
     * @param string $absorption
     * @return \Prototyping\Entity\Prototyping
     */        
    public function setAbsorption($absorption)
    {
        $this->absorption = $absorption;
        
        return $this;
    }  
    
    /**
     * Get pressure
     * 
     * @return string
     */       
    public function getPressure()
    {
        return $this->pressure;
    } 

    /**
     * Set pressure
     * 
     * @param string $pressure
     * @return \Prototyping\Entity\Prototyping
     */        
    public function setPressure($pressure)
    {
        $this->pressure = $pressure;
        
        return $this;
    }      
    
    /**
     * Get progress
     * 
     * @return string
     */       
    public function getProgress()
    {
        return $this->progress;
    } 

    /**
     * Set progress
     * 
     * @param string $progress
     * @return \Prototyping\Entity\Prototyping
     */        
    public function setProgress($progress)
    {
        $this->progress = $progress;
        
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
     * Set description
     *
     * @param string $description
     * @return \Prototyping\Entity\Prototyping
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }  
    
    /**
     * Get destination
     *
     * @return string 
     */
    public function getDestination()
    {
        return $this->destination;
    }      
    
    /**
     * Set destination
     *
     * @param string $destination
     * @return \Prototyping\Entity\Prototyping
     */
    public function setDestination($destination)
    {
        $this->destination = $destination;
    
        return $this;
    }  
          
    /**
     * Aggiunge gli allegati.
     * 
     * @param Collection $attachments gli allegati da aggioungere
     * @return \Prototyping\Entity\Prototyping
     */
    public function addAttachments(Collection $attachments)
    {
        foreach ($attachments as $row) {
            $row->setPrototyping($this);
            $this->attachments->add($row);
        }
        
        return $this;
    }

    /**
     * Rimuove gli allegati
     * @param Collection $attachments gli allegati da rimuovere
     * @return \Prototyping\Entity\Prototyping
     */
    public function removeAttachments(Collection $attachments)
    {
        foreach ($attachments as $row) {
            $row->setPrototyping(null);
            $this->attachments->removeElement($row);
        }
        
        return $this;
    }
    
    public function getAttachments()
    {   
        return $this->attachments;
    }        

    public function addHistory(Collection $history)
    {
        foreach ($history as $row) {
            $row->setPrototyping($this);
            $this->history->add($row);
        }
    }

    /**
     * Rimuove lo storico
     * @param Collection $history lo storico da rimuovere
     * @return \Prototyping\Entity\Prototyping
     */
    public function removeHistory(Collection $history)
    {
        foreach ($history as $row) {
            $row->setPrototyping(null);
            $this->history->removeElement($row);
        }
        
        return $this;
    }

    /**
     * Get history
     * @param int $type in tipo di history
     * 
     * @return Collection | Array
     */
    public function getHistory($type = 0)
    {
        if (is_numeric($type) && $type > 0) {
            $history = [];
            foreach ($this->getHistory() as $row) {
                if ($row->getPrototypingStatus()->getId() == $type)
                $history[] = $row;
            }
            return $history;
        }
        return $this->history;
    }          

    /**
     * Set status
     *
     * @param \Prototyping\Entity\Status
     * @return \Prototyping\Entity\Prototyping
     */
    public function setStatus(\Prototyping\Entity\Status $status = null)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return \Prototyping\Entity\Status 
     */
    public function getStatus()
    {
        return $this->status;
    }  
    
    /**
     * Set fsmily
     *
     * @param \Application\Entity\Family
     * @return \Prototyping\Entity\Prototyping
     */
    public function setFamily(\Application\Entity\Family $family = null)
    {
        $this->family = $family;
    
        return $this;
    }

    /**
     * Get family
     *
     * @return \Application\Entity\Family
     */
    public function getFamily()
    {
        return $this->family;
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
     * @return \Prototyping\Entity\Prototyping
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
     * @return \Prototyping\Entity\Prototyping
     */
    public function setEditDate(\DateTime $createdDate)
    {
        $this->editDate = $createdDate;

        return $this;
    }  
    
    /**
     * Get enddDate
     * 
     * @return \DateTime|NULL 
     */
    public function getEndDate()
    {
        return $this->endDate;
    }
    
    /**
     * Set endDate
     * 
     * @param \DateTime|null $endDate
     * @return \Prototyping\Entity\Prototyping
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }        
    
    /**
     * Metodo logico che mi dice se la prova è in stato "richiesta".
     * 
     * @return boolean
     */
    public function isRequired()
    {
        return ($this->getStatus()->getId() == \Prototyping\Entity\Status::STATUS_TYPE_REQUIRED);
    }  
    
    /**
     * Metodo logico che mi dice se la prova è in stato "in corso".
     * 
     * @return boolean
     */
    public function isInProgress()
    {
        return ($this->getStatus()->getId() == \Prototyping\Entity\Status::STATUS_TYPE_IN_PROGRESS);
    }     
    
    /**
     * Metodo logico che mi dice se la prova è in stato "conclusa".
     * 
     * @return boolean
     */
    public function isClosed()
    {
        return ($this->getStatus()->getId() == \Prototyping\Entity\Status::STATUS_TYPE_CLOSED);
    }       

    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {

        if (empty($this->getCreatedDate())) {
            $this->setCreatedDate(new \Datetime());
        }
    
        $this->setEditDate(new \Datetime());

    }
    
    
}
