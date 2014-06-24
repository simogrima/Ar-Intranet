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
     * Getter customer
     * 
     * @return string
     */
    public function getCustomer()
    {
        return $this->customer;
    }    
        
    /**
     * Setter customer
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
     * Getter qta
     * 
     * @return integer
     */
    public function getQta()
    {
        return $this->qta;
    }    
        
    /**
     * Setter qta
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
     * Getter qtaExpected
     * 
     * @return integer
     */
    public function getQtaExpected()
    {
        return $this->qtaExpected;
    }    
        
    /**
     * Setter qtaExpected
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
     * Getter voltage
     * 
     * @return string
     */
    public function getVoltage()
    {
        return $this->voltage;
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
     * Getter plug
     * 
     * @return string
     */
    public function getPlug()
    {
        return $this->plug;
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
     * Getter frequency
     * 
     * @return string
     */
    public function getFrequency()
    {
        return $this->frequency;
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
     * Getter serigraphy
     * 
     * @return string
     */
    public function getSerigraphy()
    {
        return $this->serigraphy;
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
     * Getter colors
     * 
     * @return string
     */
    public function getColors()
    {
        return $this->colors;
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
     * Getter cable
     * 
     * @return string
     */
    public function getCable()
    {
        return $this->cable;
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
     * Getter accessories
     * 
     * @return string
     */
    public function getAccessories()
    {
        return $this->accessories;
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
     * Getter requestedDeliveryDate
     * 
     * @return \DateTime 
     */
    public function getRequestedDeliveryDate()
    {
        return $this->requestedDeliveryDate;
    }    

    /**
     * Setter requestedDeliveryDate
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
     * Getter paymentTerm
     * 
     * @return string
     */
    public function getPaymentTerm()
    {
        return $this->paymentTerm;
    }
    
    /**
     * Setter paymentTerm
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
     * Getter standardProduct
     * 
     * @return string
     */    
    public function getStandardProduct()
    {
        return $this->standardProduct;
    }

    /**
     * Setter standardProduct
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
     * Getter approvalSample
     * 
     * @return string
     */        
    public function getApprovalSample()
    {
        return $this->approvalSample;
    }

    /**
     * Setter approvalSample
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
     * Getter vpp
     * 
     * @return string
     */       
    public function getVpp()
    {
        return $this->vpp;
    }

    /**
     * Getter booklet
     * 
     * @return string
     */       
    public function getBooklet()
    {
        return $this->booklet;
    }

    /**
     * Getter packaging
     * 
     * @return string
     */       
    public function getPackaging()
    {
        return $this->packaging;
    }

    /**
     * Setter vpp
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
     * Setter booklet
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
     * Setter packaging
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
     * Getter createDate
     * 
     * @return \DateTime 
     */
    public function getCreatedDate()
    {
        return $this->createdDate;
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
     * Getter editDate
     * 
     * @return \DateTime 
     */
    public function getEditDate()
    {
        return $this->editDate;
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
