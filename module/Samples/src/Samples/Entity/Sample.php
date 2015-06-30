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
     * @var integer
     *
     * @ORM\Column(name="painting", type="smallint", nullable=false, options={"default" = 0})
     */
    protected $painting;       
        
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
    protected $booklet;  
    
    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=128)
     */
    protected $packaging;      
    
    
    /**
     * @var string|null
     *
     * @ORM\Column(name="voltage_provided", type="string", nullable=true, length=128)
     */
    protected $voltageProvided; //tensione

    /**
     * @var string|null
     *
     * @ORM\Column(name="plug_provided", type="string", nullable=true, length=128)
     */
    protected $plugProvided; //spina

    /**
     * @var string|null
     *
     * @ORM\Column(name="frequency_provided", type="string", nullable=true, length=128)
     */
    protected $frequencyProvided; //frequenza

    /**
     * @var string|null
     *
     * @ORM\Column(name="serigraphy_provided", type="string", nullable=true, length=128)
     */
    protected $serigraphyProvided; //serigrafia

    /**
     * @var string|null
     *
     * @ORM\Column(name="colors_provided", type="string", nullable=true, length=128)
     */
    protected $colorsProvided; //frequenza

    /**
     * @var string|null
     *
     * @ORM\Column(name="cable_provided", type="string", nullable=true, length=128)
     */
    protected $cableProvided; //frequenza

    /**
     * @var string|null
     *
     * @ORM\Column(name="accessories_provided", type="string", nullable=true, length=128)
     */
    protected $accessoriesProvided;    
    
    /**
     * @var string|null
     *
     * @ORM\Column(name="booklet_provided", type="string", nullable=true, length=128)
     */
    protected $bookletProvided;  
    
    /**
     * @var string|null
     *
     * @ORM\Column(name="packaging_provided", type="string", nullable=true, length=128)
     */
    protected $packagingProvided;     
    
    /**
     * @var string|null
     *
     * @ORM\Column(name="absorption_provided", type="string", nullable=true, length=128)
     */
    protected $absorptionProvided;    
    
    /**
     * @var string|null
     *
     * @ORM\Column(name="pressure_provided", type="string", nullable=true, length=128)
     */
    protected $pressureProvided;      
    
    /**
     * @var string|null
     *
     * @ORM\Column(name="sfasamento_provided", type="string", nullable=true, length=128)
     */
    protected $sfasamentoProvided;       
    
    /**
     * @var string|null
     *
     * @ORM\Column(name="edt_provided", type="string", nullable=true, length=128)
     */
    protected $edtProvided;       
    
    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=128)
     */
    protected $vpp;   
    
    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $note;    
    
    /**
     * @var string
     *
     * @ORM\Column(name="note_provided", type="text", nullable=true)
     */
    protected $noteProvided;        
      
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
     * @var integer
     *
     * @ORM\Column(name="email1", type="smallint", nullable=false, options={"default" = 0})
     */
    protected $email1;        
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="scheduled_delivery_date", type="datetime", nullable=true)
     */
    protected $scheduledDeliveryDate;    
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="current_status_date", type="datetime", nullable=true)
     */
    protected $currentStatusDate;       
    
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
     * @ORM\OneToMany(targetEntity="Samples\Entity\History", mappedBy="sample", cascade={"remove"})
     */
    protected $history;      
    
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
     * Get booklet
     * 
     * @return string
     */       
    public function getBooklet()
    {
        return $this->booklet;
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
     * Get packaging
     * 
     * @return string
     */       
    public function getPackaging()
    {
        return $this->packaging;
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
     * Get voltageProvided
     * 
     * @return string
     */
    public function getVoltageProvided()
    {
        return $this->voltageProvided;
    }
    
    /**
     * Set voltageProvided
     * 
     * @param string $voltageProvided
     * @return \Samples\Entity\Sample
     */
    public function setVoltageProvided($voltageProvided)
    {
        $this->voltageProvided = $voltageProvided;

        return $this;
    }    

    /**
     * Get plugProvided
     * 
     * @return string
     */
    public function getPlugProvided()
    {
        return $this->plugProvided;
    }

    /**
     * Set plugProvided
     * 
     * @param string $plugProvided
     * @return \Samples\Entity\Sample
     */
    public function setPlugProvided($plugProvided)
    {
        $this->plugProvided = $plugProvided;

        return $this;
    }    

    /**
     * Get frequencyV
     * 
     * @return string
     */
    public function getFrequencyProvided()
    {
        return $this->frequencyProvided;
    }
    
    /**
     * Set frequencyProvided
     * 
     * @param string $frequencyProvided
     * @return \Samples\Entity\Sample
     */
    public function setFrequencyProvided($frequencyProvided)
    {
        $this->frequencyProvided = $frequencyProvided;

        return $this;
    }    

    /**
     * Get serigraphyProvided
     * 
     * @return string
     */
    public function getSerigraphyProvided()
    {
        return $this->serigraphyProvided;
    }

    /**
     * Set serigraphyProvided
     * 
     * @param string $serigraphyProvided
     * @return \Samples\Entity\Sample
     */
    public function setSerigraphyProvided($serigraphyProvided)
    {
        $this->serigraphyProvided = $serigraphyProvided;

        return $this;
    }    

    /**
     * Get colorsProvided
     * 
     * @return string
     */
    public function getColorsProvided()
    {
        return $this->colorsProvided;
    }
    
    /**
     * Set colorsProvided
     * 
     * @param string $colorsProvided
     * @return \Samples\Entity\Sample
     */
    public function setColorsProvided($colorsProvided)
    {
        $this->colorsProvided = $colorsProvided;

        return $this;
    }    

    /**
     * Get cableProvided
     * 
     * @return string
     */
    public function getCableProvided()
    {
        return $this->cableProvided;
    }

    /**
     * Set cableProvided
     * 
     * @param string $cableProvided
     * @return \Samples\Entity\Sample
     */
    public function setCableProvided($cableProvided)
    {
        $this->cableProvided = $cableProvided;

        return $this;
    }    

    /**
     * Get accessoriesProvided
     * 
     * @return string
     */
    public function getAccessoriesProvided()
    {
        return $this->accessoriesProvided;
    }
    
    /**
     * Set accessoriesProvided
     * 
     * @param string $accessoriesProvided
     * @return \Samples\Entity\Sample
     */
    public function setAccessoriesProvided($accessoriesProvided)
    {
        $this->accessoriesProvided = $accessoriesProvided;

        return $this;
    }    
    
    /**
     * Get bookletProvided
     * 
     * @return string
     */       
    public function getBookletProvided()
    {
        return $this->bookletProvided;
    }

    /**
     * Set bookletProvided
     * 
     * @param string $bookletProvided
     * @return \Samples\Entity\Sample
     */        
    public function setBookletProvided($bookletProvided)
    {
        $this->bookletProvided = $bookletProvided;
        
        return $this;
    }
    
    /**
     * Get packagingProvided
     * 
     * @return string
     */       
    public function getPackagingProvided()
    {
        return $this->packagingProvided;
    } 

    /**
     * Set packagingProvided
     * 
     * @param string $packagingProvided
     * @return \Samples\Entity\Sample
     */        
    public function setPackagingProvided($packagingProvided)
    {
        $this->packagingProvided = $packagingProvided;
        
        return $this;
    }     
    
    /**
     * Get absorptionProvided
     * 
     * @return string
     */       
    public function getAbsorptionProvided()
    {
        return $this->absorptionProvided;
    } 

    /**
     * Set absorptionProvided
     * 
     * @param string $absorptionProvided
     * @return \Samples\Entity\Sample
     */        
    public function setAbsorptionProvided($absorptionProvided)
    {
        $this->absorptionProvided = $absorptionProvided;
        
        return $this;
    }  
    
    /**
     * Get pressureProvided
     * 
     * @return string
     */       
    public function getPressureProvided()
    {
        return $this->pressureProvided;
    } 

    /**
     * Set pressureProvided
     * 
     * @param string $pressureProvided
     * @return \Samples\Entity\Sample
     */        
    public function setPressureProvided($pressureProvided)
    {
        $this->pressureProvided = $pressureProvided;
        
        return $this;
    }      
    
    /**
     * Get sfasamentoProvided
     * 
     * @return string
     */       
    public function getSfasamentoProvided()
    {
        return $this->sfasamentoProvided;
    } 

    /**
     * Set sfasamentoProvided
     * 
     * @param string $sfasamentoProvided
     * @return \Samples\Entity\Sample
     */        
    public function setSfasamentoProvided($sfasamentoProvided)
    {
        $this->sfasamentoProvided = $sfasamentoProvided;
        
        return $this;
    }   
    
    /**
     * Get edtProvided
     * 
     * @return string
     */       
    public function getEdtProvided()
    {
        return $this->edtProvided;
    } 

    /**
     * Set edtProvided
     * 
     * @param string $edtProvided
     * @return \Samples\Entity\Sample
     */        
    public function setEdtProvided($edtProvided)
    {
        $this->edtProvided = $edtProvided;
        
        return $this;
    }      
    
    /**
     * Get standardProduct
     * 
     * @return string
     */    
    public function getStandardProduct($human = FALSE)
    {
        if ($human) {
            return ($this->standardProduct == 1) ? 'Yes' : 'No';
        }
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
    public function getApprovalSample($human = FALSE)
    {
        if ($human) {
            return ($this->approvalSample == 1) ? 'Yes' : 'No';
        }        
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
     * Get email1
     * 
     * @return string
     */        
    public function getEmail1($human = FALSE)
    {
        if ($human) {
            return ($this->email1 == 1) ? 'Yes' : 'No';
        }        
        return $this->email1;
    }

    /**
     * Set email1
     * 
     * @param string $email1
     * @return \Samples\Entity\Sample
     */      
    public function setEmail1($email1)
    {
        $this->email1 = $email1;
        
        return $this;
    }        
    
    /**
     * Get painting
     * 
     * @return string
     */        
    public function getPainting($human = FALSE)
    {
        if ($human) {
            return ($this->painting == 1) ? 'Yes' : 'No';
        }        
        return $this->painting;
    }

    /**
     * Set painting
     * 
     * @param string $painting
     * @return \Samples\Entity\Sample
     */      
    public function setPainting($painting)
    {
        $this->painting = $painting;
        
        return $this;
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
     * Get vpp
     * 
     * @return string
     */       
    public function getVpp()
    {
        return $this->vpp;
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
        $this->note = $note;
    
        return $this;
    }
    
    /**
     * Get noteProvided
     *
     * @return string 
     */
    public function getNoteProvided()
    {
        return $this->noteProvided;
    }      
    
    /**
     * Set noteProvided
     *
     * @param string $noteProvided
     * @return \Samples\Entity\Sample
     */
    public function setNoteProvided($note)
    {
        $this->noteProvided = $note;
    
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
        if ($type && in_array($type, \Samples\Entity\Attachments::getAttachmentTypeValues())) {
            $attachments = [];
            foreach ($this->getAttachments() as $row) {
                if ($row->getAttachmentType() == $type)
                $attachments[] = $row;
            }
            return $attachments;
        }
        
        return $this->attachments;
    }        

    public function addHistory(Collection $history)
    {
        foreach ($history as $row) {
            $row->setSample($this);
            $this->history->add($row);
        }
    }

    /**
     * Rimuove lo storico di un computer
     * @param Collection $history lo storico da rimuovere
     * @return \Samples\Entity\Sample
     */
    public function removeHistory(Collection $history)
    {
        foreach ($history as $row) {
            $row->setSample(null);
            $this->history->removeElement($row);
        }
        
        return $this;
    }

    /**
     * Get computer history
     * @param int $type in tipo di history
     * 1 -> Emessa
     * 5 -> Prodotto richiesto
     * 10 -> Prodotto arrivato
     * 15 -> Evasa
     * 20 -> Spedita
     * 25 -> Annullata
     * 
     * @return Collection | Array
     */
    public function getHistory($type = 0)
    {
        if (is_numeric($type) && $type > 0) {
            $history = [];
            foreach ($this->getHistory() as $row) {
                if ($row->getSampleStatus()->getId() == $type)
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
     * Get scheduledDeliveryDate
     * 
     * @return \DateTime 
     */
    public function getScheduledDeliveryDate()
    {
        return $this->scheduledDeliveryDate;
    }    

    /**
     * Set scheduledDeliveryDate
     * 
     * @param \DateTime $scheduledDeliveryDate
     * @return \Samples\Entity\Sample
     */
    public function setScheduledDeliveryDate(\DateTime $scheduledDeliveryDate)
    {
        $this->scheduledDeliveryDate = $scheduledDeliveryDate;

        return $this;
    }     
    
    /**
     * Get currentStatusDate
     * 
     * @return \DateTime 
     */
    public function getCurrentStatusDate()
    {
        return $this->currentStatusDate;
    }    

    /**
     * Set currentStatusDate
     * 
     * @param \DateTime $currentStatusDate
     * @return \Samples\Entity\Sample
     */
    public function setCurrentStatusDate(\DateTime $currentStatusDate)
    {
        $this->currentStatusDate = $currentStatusDate;

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
    public function setEditDate(\DateTime $createdDate)
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
     * Metodo logico che mi dice se la campionatura è in stato spedito.
     * 
     * @return boolean
     */
    public function isShipped()
    {
        return ($this->getStatus()->getId() == \Samples\Entity\Status::STATUS_TYPE_SHIPPED);
    }  
    
    /**
     * Metodo logico che mi dice se la campionatura è in stato evasa.
     * 
     * @return boolean
     */
    public function isProcessed()
    {
        return ($this->getStatus()->getId() == \Samples\Entity\Status::STATUS_TYPE_PROCESSED);
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
