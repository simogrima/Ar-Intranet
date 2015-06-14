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
    protected $customer;    
    
    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=128)
     */
    protected $model;
    
    /**
     * @var int
     *
     * @ORM\Column(type="smallint", options={"unsigned"=true, "default" = 0})
     */
    protected $qta;
   
    /**
     * @var int
     *
     * @ORM\Column(name="qta_expected", type="integer", options={"unsigned"=true, "default" = 0})
     */
    protected $qtaExpected;        
              
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="requested_delivery_date", type="datetime", nullable=false)
     */
    protected $requestedDeliveryDate;
    
    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=128)
     */
    protected $paymentTerm;    
    
    /**
     * @var integer
     *
     * @ORM\Column(name="standard_product", type="smallint", nullable=false, options={"default" = 0})
     */
    protected $standardProduct;    
    
    /**
     * @var integer
     *
     * @ORM\Column(name="approval_sample", type="smallint", nullable=false, options={"default" = 0})
     */
    protected $approvalSample;        
        
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
    protected $accessories;    
    
    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=128)
     */
    protected $vpp;
    
    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=128)
     */
    protected $booklet;  
    
    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=128)
     */
    protected $packaging;     
    
    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $note;    
      
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
     * @var \Application\Entity\Country
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\Country", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="country_id", nullable=true, referencedColumnName="country_id")
     * })
     */
    protected $country;       
    
    /**
     * Richiedente campionatura 
     * @var \User\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="User\Entity\User", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="applicant", nullable=true, referencedColumnName="id")
     * })
     */
    protected $applicant;         
    
    /**
     * @ORM\OneToMany(targetEntity="Samples\Entity\Attachments", mappedBy="sample", cascade={"remove"})
     */
    protected $attachments;   
    
    /**
     * @var \Samples\Entity\Status
     *
     * @ORM\ManyToOne(targetEntity="Samples\Entity\Status", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="status_id", nullable=true, referencedColumnName="id")
     * })
     */
    protected $status;       
    
    /**
     * Never forget to initialize all your collections !
     */
    public function __construct()
    {
        $this->attachments = new ArrayCollection();
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
     * @return \Samples\Entity\Sample
     */
    public function setModel($model)
    {
        $this->model = $model;

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
     * @return \Samples\Entity\Sample
     */
    public function setCustomer($customer)
    {
        $this->customer = $customer;

        return $this;
    }     
    
    /**
     * Get qta
     * 
     * @return integer
     */
    public function getQta()
    {
        return $this->qta;
    }    
        
    /**
     * Set qta
     * 
     * @param int $qta
     * @return \Samples\Entity\Sample
     */
    public function setQta($qta)
    {
        $this->qta = $qta;

        return $this;
    }     
    
    /**
     * Get qtaExpected
     * 
     * @return integer
     */
    public function getQtaExpected()
    {
        return $this->qtaExpected;
    }    
        
    /**
     * Set qtaExpected
     * 
     * @param int $qtaExpected
     * @return \Samples\Entity\Sample
     */
    public function setQtaExpected($qtaExpected)
    {
        $this->qtaExpected = $qtaExpected;

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
     * @return \Samples\Entity\Sample
     */
    public function setVoltage($voltage)
    {
        $this->voltage = $voltage;

        return $this;
    }    

    /**
     * Get plug
     * 
     * @return string
     */
    public function getPlug()
    {
        return $this->plug;
    }

    /**
     * Set plug
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
     * @return \Samples\Entity\Sample
     */
    public function setFrequency($frequency)
    {
        $this->frequency = $frequency;

        return $this;
    }    

    /**
     * Get serigraphy
     * 
     * @return string
     */
    public function getSerigraphy()
    {
        return $this->serigraphy;
    }

    /**
     * Set serigraphy
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
     * Get colors
     * 
     * @return string
     */
    public function getColors()
    {
        return $this->colors;
    }
    
    /**
     * Set colors
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
     * Get cable
     * 
     * @return string
     */
    public function getCable()
    {
        return $this->cable;
    }

    /**
     * Set cable
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
     * Get accessories
     * 
     * @return string
     */
    public function getAccessories()
    {
        return $this->accessories;
    }
    
    /**
     * Set accessories
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
     * Get requestedDeliveryDate
     * 
     * @return \DateTime 
     */
    public function getRequestedDeliveryDate()
    {
        return $this->requestedDeliveryDate;
    }    

    /**
     * Set requestedDeliveryDate
     * 
     * @param \DateTime $requestedDeliveryDate
     * @return \Samples\Entity\Sample
     */
    public function setRequestedDeliveryDate(\DateTime $requestedDeliveryDate)
    {
        $this->requestedDeliveryDate = $requestedDeliveryDate;

        return $this;
    }     
    
    /**
     * Get paymentTerm
     * 
     * @return string
     */
    public function getPaymentTerm()
    {
        return $this->paymentTerm;
    }
    
    /**
     * Set paymentTerm
     * 
     * @param string $paymentTerm
     * @return \Samples\Entity\Sample
     */
    public function setPaymentTerm($paymentTerm)
    {
        $this->paymentTerm = $paymentTerm;

        return $this;
    }       
    
    /**
     * Get standardProduct
     * 
     * @return string
     */    
    public function getStandardProduct()
    {
        return $this->standardProduct;
    }

    /**
     * Set standardProduct
     * 
     * @param string $standardProduct
     * @return \Samples\Entity\Sample
     */    
    public function setStandardProduct($standardProduct)
    {
        $this->standardProduct = $standardProduct;
        
        return $this;
    }
    
    /**
     * Get approvalSample
     * 
     * @return string
     */        
    public function getApprovalSample()
    {
        return $this->approvalSample;
    }

    /**
     * Set approvalSample
     * 
     * @param string $approvalSample
     * @return \Samples\Entity\Sample
     */      
    public function setApprovalSample($approvalSample)
    {
        $this->approvalSample = $approvalSample;
        
        return $this;
    }
    
    /**
     * Get vpp
     * 
     * @return string
     */       
    public function getVpp()
    {
        return $this->vpp;
    }

    /**
     * Get booklet
     * 
     * @return string
     */       
    public function getBooklet()
    {
        return $this->booklet;
    }

    /**
     * Get packaging
     * 
     * @return string
     */       
    public function getPackaging()
    {
        return $this->packaging;
    }

    /**
     * Set vpp
     * 
     * @param string $vpp
     * @return \Samples\Entity\Sample
     */        
    public function setVpp($vpp)
    {
        $this->vpp = $vpp;
        
        return $this;
    }

    /**
     * Set booklet
     * 
     * @param string $booklet
     * @return \Samples\Entity\Sample
     */        
    public function setBooklet($booklet)
    {
        $this->booklet = $booklet;
        
        return $this;
    }

    /**
     * Set packaging
     * 
     * @param string $packaging
     * @return \Samples\Entity\Sample
     */        
    public function setPackaging($packaging)
    {
        $this->packaging = $packaging;
        
        return $this;
    } 
    
    /**
     * Get note
     *
     * @return string 
     */
    public function getNote()
    {
        return $this->note;
    }      
    
    /**
     * Set note
     *
     * @param string $note
     * @return \Samples\Entity\Sample
     */
    public function setNote($note)
    {
        $this->content = $note;
    
        return $this;
    }
    
    /**
     * Set applicant
     *
     * @param \User\Entity\User
     * @return \Samples\Entity\Sample
     */
    public function setApplicant(\User\Entity\User $user = null)
    {
        $this->applicant = $user;

        return $this;
    }   

    /**
     * Get recipient
     *
     * @return \User\Entity\User
     */
    public function getApplicant()
    {
        return $this->applicant;
    }      
    
    /**
     * Aggiunge gli allegati ad una richiesta.
     * 
     * @param Collection $attachments gli allegati da aggioungere
     * @return \Samples\Entity\Sample
     */
    public function addAttachments(Collection $attachments)
    {
        foreach ($attachments as $row) {
            $row->setComputer($this);
            $this->attachments->add($row);
        }
        
        return $this;
    }

    /**
     * Rimuove gli allegati di una richiesta
     * @param Collection $attachments gli allegati da rimuovere
     * @return \Samples\Entity\Sample
     */
    public function removeAttachments(Collection $attachments)
    {
        foreach ($attachments as $row) {
            $row->setComputer(null);
            $this->attachments->removeElement($row);
        }
        
        return $this;
    }
    
    public function getAttachments($type = null)
    {
        
        return $this->attachments;
    }        

    /**
     * Get computer history
     * @param int $type in tipo di history
     * 0 -> all
     * 1 -> Creazione
     * 2 -> Modifica
     * 3 -> Assegnazione
     * 4 -> Cambio stato
     * 
     * @return Collection | Array
     */
    public function getHistory($type = 0)
    {
        if (is_numeric($type) && $type > 0) {
            $history = [];
            foreach ($this->getHistory() as $row) {
                if ($row->getType() == $type)
                $history[] = $row;
            }
            return $history;
        }
        return $this->history;
    }   
    
    /**
     * Set status
     *
     * @param \Computer\Entity\Status
     * @return \Samples\Entity\Sample
     */
    public function setStatus(\Samples\Entity\Status $status = null)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return \Samples\Entity\Status 
     */
    public function getStatus()
    {
        return $this->status;
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
     * @return \Samples\Entity\Sample
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
     * @return \Samples\Entity\Sample
     */
    public function setEditdDate(\DateTime $createdDate)
    {
        $this->editDate = $createdDate;

        return $this;
    }  
    
    /**
     * Set country
     *
     * @param \Application\Entity\Country
     * @return \Samples\Entity\Sample
     */
    public function setCountry(\Application\Entity\Country $country = null)
    {
        $this->country = $country;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return \Application\Entity\Country 
     */
    public function getCountry()
    {
        return $this->country;
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
