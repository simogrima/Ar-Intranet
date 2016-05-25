<?php

namespace Proto\Entity;

use Doctrine\Common\Collections\ArrayCollection,
    Doctrine\Common\Collections\Collection,
    Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="proto_supplies")
 */
class Supplies
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
     * @var \Proto\Entity\Proto
     *
     * @ORM\ManyToOne(targetEntity="Proto\Entity\Proto", inversedBy="supplies", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="proto_id", nullable=true, referencedColumnName="id")
     * })
     */
    protected $proto; 
    
    /**
     * @var \Application\Entity\Supplier
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\Supplier", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="supplier_id", nullable=true, referencedColumnName="id")
     * })
     */
    protected $supplier;     
    
     
    
    /**
     * @var string|null
     *
     * @ORM\Column(name="order_nr", type="string", length=64)
     */
    protected $orderNr;   
       

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="supply_date", type="datetime", nullable=false)
     */
    protected $supplyDate;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_date", type="datetime", nullable=false)
     */
    protected $createdDate;    
    
    /**
     * @ORM\OneToMany(targetEntity="Proto\Entity\Attachments", mappedBy="supply", cascade={"remove"})
     */
    protected $attachments;      

    /**
     * Never forget to initialize all your collections !
     */
    public function __construct()
    {
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
     * Set proto
     *
     * @param \Proto\Entity\Proto
     * @return \Proto\Entity\Supplies
     */
    public function setProto(\Proto\Entity\Proto $proto = null)
    {
        $this->proto = $proto;

        return $this;
    }

    /**
     * Get Proto
     *
     * @return \Proto\Entity\Proto
     */
    public function getProto()
    {
        return $this->proto;
    }    
    
    /**
     * Set supplier
     *
     * @param \Application\Entity\Supplier
     * @return \Proto\Entity\Supplies
     */
    public function setSupplier(\Application\Entity\Supplier $supplier = null)
    {
        $this->supplier = $supplier;

        return $this;
    }

    /**
     * Get Supplier
     *
     * @return \Application\Entity\Supplier
     */
    public function getSupplier()
    {
        return $this->supplier;
    }      
    
    /**
     * Get orderNr
     * 
     * @return string
     */
    public function getOrderNr()
    {
        return $this->orderNr;
    }
    
    /**
     * Set filename
     * 
     * @param string $orderNr
     * @return \Proto\Entity\Supplies
     */
    public function setOrderNr($orderNr)
    {
        $this->orderNr = $orderNr;

        return $this;
    }   
    
    
    /**
     * Aggiunge gli allegati.
     * 
     * @param Collection $attachments gli allegati da aggiungere
     * @return \Proto\Entity\Supplies
     */
    public function addAttachments(Collection $attachments)
    {
        foreach ($attachments as $row) {
            $row->setSupply($this);
            $this->attachments->add($row);
        }
        
        return $this;
    }

    /**
     * Rimuove gli allegati
     * @param Collection $attachments gli allegati da rimuovere
     * @return \Proto\Entity\Supplies
     */
    public function removeAttachments(Collection $attachments)
    {
        foreach ($attachments as $row) {
            $row->setSupply(null);
            $this->attachments->removeElement($row);
        }
        
        return $this;
    }    
    
    public function getAttachments($type = null)
    {
        if ($type && in_array($type, \Proto\Entity\Attachments::getAttachmentTypeValues())) {
            $attachments = [];
            foreach ($this->getAttachments() as $row) {
                if ($row->getAttachmentType() == $type)
                $attachments[] = $row;
            }
            return $attachments;
        }
        
        return $this->attachments;
    }        
    
    

    /**
     * Get supplyDate
     * 
     * @return \DateTime 
     */
    public function getSupplyDate()
    {
        return $this->supplyDate;
    }
    
    /**
     * Set supplyDate
     * 
     * @param \DateTime $supplyDate
     * @return \Proto\Entity\Supplies
     */
    public function setSupplyDate(\DateTime $supplyDate)
    {
        $this->supplyDate = $supplyDate;

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
     * @return \Proto\Entity\Supplies
     */
    public function setCreatedDate(\DateTime $createdDate)
    {
        $this->createdDate = $createdDate;

        return $this;
    }      


    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        if (empty($this->getCreatedDate())) {
            $this->setCreatedDate(new \Datetime());
        }
    }
}
