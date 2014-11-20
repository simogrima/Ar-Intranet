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
     * @var string|null
     *
     * @ORM\Column(type="string", length=64)
     */
    protected $invoice;    
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="invoice_date", type="datetime", nullable=false)
     */
    protected $invoiceDate;        
    
    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=64)
     */
    protected $ddt;    
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="ddt_date", type="datetime", nullable=false)
     */
    protected $ddtDate;    
      
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
     * @var \Computer\Entity\Brand
     *
     * @ORM\ManyToOne(targetEntity="Computer\Entity\Brand", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="brand_id", nullable=true, referencedColumnName="id")
     * })
     */
    protected $brand;  
    
    /**
     * @var \Computer\Entity\Processor
     *
     * @ORM\ManyToOne(targetEntity="Computer\Entity\Processor", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="processor_id", nullable=true, referencedColumnName="id")
     * })
     */
    protected $processor;      
    
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
     * @ORM\OneToMany(targetEntity="Computer\Entity\History", mappedBy="computer", cascade={"persist"})
     */
    protected $history;    
    
    /**
     * Never forget to initialize all your collections !
     */
    public function __construct()
    {
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
     * Get invoice
     * 
     * @return string
     */
    public function getInvoice()
    {
        return $this->invoice;
    }
    
    /**
     * Set invoice
     * 
     * @param string $invoice
     * @return \Computer\Entity\Computer
     */
    public function setInvoice($invoice)
    {
        $this->invoice = $invoice;

        return $this;
    }       
    
    /**
     * Get invoiceDate
     * 
     * @return \DateTime 
     */
    public function getInvoiceDate()
    {
        return $this->invoiceDate;
    }    

    /**
     * Set invoiceDate
     * 
     * @param \DateTime $invoiceDate
     * @return \Samples\Entity\Computer
     */
    public function setInvoiceDate(\DateTime $invoiceDate)
    {
        $this->invoiceDate = $invoiceDate;

        return $this;
    }       
    
    /**
     * Get ddt
     * 
     * @return string
     */
    public function getDdt()
    {
        return $this->ddt;
    }
    
    /**
     * Set ddt
     * 
     * @param string $ddt
     * @return \Computer\Entity\Computer
     */
    public function setDdt($ddt)
    {
        $this->ddt = $ddt;

        return $this;
    }       
    
    /**
     * Get ddtDate
     * 
     * @return \DateTime 
     */
    public function getDdtDate()
    {
        return $this->ddtDate;
    }    

    /**
     * Set ddtDate
     * 
     * @param \DateTime $ddtDate
     * @return \Samples\Entity\Computer
     */
    public function setDdtDate(\DateTime $ddtDate)
    {
        $this->ddtDate = $ddtDate;

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
     * Set category
     *
     * @param \Computer\Entity\Category
     * @return \Computer\Entity\Computer
     */
    public function setCategory(\Computer\Entity\Category $category = null)
    {
        $this->category = $category;
    
        return $this;
    }

    /**
     * Get category
     *
     * @return \Computer\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }  
    
    /**
     * Set brand
     *
     * @param \Computer\Entity\Brand
     * @return \Computer\Entity\Computer
     */
    public function setBrand(\Computer\Entity\Brand $brand = null)
    {
        $this->brand = $brand;
    
        return $this;
    }

    /**
     * Get brand
     *
     * @return \Computer\Entity\Brand
     */
    public function getBrand()
    {
        return $this->brand;
    }      
    
    /**
     * Set processor
     *
     * @param \Computer\Entity\Processor
     * @return \Computer\Entity\Computer
     */
    public function setProcessor(\Computer\Entity\Processor $processor = null)
    {
        $this->processor = $processor;
    
        return $this;
    }

    /**
     * Get processor
     *
     * @return \Computer\Entity\Processor
     */
    public function getProcessor()
    {
        return $this->processor;
    }      
    
    public function addHistory(Collection $history)
    {
        foreach ($history as $row) {
            $row->setComputer($this);
            $this->history->add($row);
        }
    }

    public function removeHistory(Collection $history)
    {
        foreach ($history as $row) {
            $row->setComputer(null);
            $this->history->removeElement($row);
        }
    }

    public function getHistory()
    {
        return $this->history;
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
