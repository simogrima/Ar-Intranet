<?php

namespace Proto\Entity;

use Doctrine\Common\Collections\ArrayCollection,
    Doctrine\Common\Collections\Collection,
    Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="proto")
 */
class Proto
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
     * @ORM\Column(type="string", nullable=true, length=128)
     */
    protected $type;        
    
    /**
     * @var integer
     *
     * @ORM\Column(name="parti_plastiche", type="smallint", nullable=false, options={"default" = 0})
     */
    protected $partiPlastiche;        
    
    /**
     * @var integer
     *
     * @ORM\Column(name="parti_lav_metallo", type="smallint", nullable=false, options={"default" = 0})
     */
    protected $partiLavMetallo;      
    
    /**
     * @var integer
     *
     * @ORM\Column(name="parti_trasparenti", type="smallint", nullable=false, options={"default" = 0})
     */
    protected $partiTrasparenti;      
    
    /**
     * @var integer
     *
     * @ORM\Column(name="parti_verniciate", type="smallint", nullable=false, options={"default" = 0})
     */
    protected $partiVerniciate;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="parti_gomma", type="smallint", nullable=false, options={"default" = 0})
     */
    protected $partiGomma;        
    
    /**
     * @var integer
     *
     * @ORM\Column(name="parti_mat_speciale", type="smallint", nullable=false, options={"default" = 0})
     */
    protected $partiMatSpeciale;        
    
    /**
     * @var string
     *
     * @ORM\Column(name="note_parti_mat_speciale", type="text", nullable=true)
     */
    protected $notePartiMatSpeciale;       
    
    /**
     * @var string
     *
     * @ORM\Column(type="smallint", nullable=false, options={"default" = 0})
     */
    protected $serigrafie;    
    
    /**
     * @var string
     *
     * @ORM\Column(name="destinazione_uso", type="text", nullable=true)
     */
    protected $destinazioneUso;   

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true, length=128)
     */
    protected $tensione;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true, length=128)
     */
    protected $frequenza;
    
    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true, length=128)
     */
    protected $potenza;
    
    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true, length=128)
     */
    protected $spina;    
    
    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true, length=128)
     */
    protected $cavo; 
    
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
    protected $varie;      
    
    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $note;   
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="requested_delivery_date", type="datetime", nullable=false)
     */
    protected $requestedDeliveryDate;     
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="expected_delivery_date", type="datetime", nullable=true)
     */
    protected $expectedDeliveryDate;        
    
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
     * @ORM\OneToMany(targetEntity="Proto\Entity\Attachments", mappedBy="proto", cascade={"remove"})
     */
    protected $attachments;   
    
    /**
     * @ORM\OneToMany(targetEntity="Proto\Entity\History", mappedBy="proto", cascade={"remove"})
     */
    protected $history;      
    
    /**
     * @var \Proto\Entity\Status
     *
     * @ORM\ManyToOne(targetEntity="Proto\Entity\Status", cascade={"persist"})
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
     * Richiedente prototipo
     * @var \User\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="User\Entity\User", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="applicant", nullable=true, referencedColumnName="id")
     * })
     */
    protected $applicant;    
    
    /**
     * @ORM\OneToMany(targetEntity="Proto\Entity\Supplies", mappedBy="proto", cascade={"remove"})
     */
    protected $supplies;      
    
    /**
     * Never forget to initialize all your collections !
     */
    public function __construct()
    {
        $this->attachments = new ArrayCollection();
        $this->history = new ArrayCollection();
        $this->supplies = new ArrayCollection();
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
     * @return \Proto\Entity\Proto
     */
    public function setProjectCode($projectCode)
    {
        $this->projectCode = $projectCode;

        return $this;
    }       
    
    /**
     * Get type
     * 
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
 
    /**
     * Set type
     * 
     * @param string $type
     * @return \Proto\Entity\Proto
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }     
    
    /**
     * Get partiPlastiche
     * 
     * @return string
     */    
    function getPartiPlastiche($human = false)
    {
        if ($human) {
            return ($this->partiPlastiche == 1) ? 'Yes' : 'No';
        }        
        return $this->partiPlastiche;
    }

    /**
     * Get partiLaMetallo
     * 
     * @return string
     */   
    function getPartiLavMetallo($human = false)
    {
        if ($human) {
            return ($this->partiLavMetallo == 1) ? 'Yes' : 'No';
        }        
        return $this->partiLavMetallo;
    }

    /**
     * Get partiTrasparenti
     * 
     * @return string
     */      
    function getPartiTrasparenti($human = false)
    {
        if ($human) {
            return ($this->partiTrasparenti == 1) ? 'Yes' : 'No';
        }        
        return $this->partiTrasparenti;
    }

    function getPartiVerniciate($human = false)
    {
        if ($human) {
            return ($this->partiVerniciate == 1) ? 'Yes' : 'No';
        }        
        return $this->partiVerniciate;
    }

    /**
     * Get partiGomma
     * 
     * @return string
     */      
    function getPartiGomma($human = false)
    {
        if ($human) {
            return ($this->partiGomma == 1) ? 'Yes' : 'No';
        }        
        return $this->partiGomma;
    }

    /**
     * Get partiMatSpeciale
     * 
     * @return string
     */      
    function getPartiMatSpeciale($human = false)
    {
        if ($human) {
            return ($this->partiMatSpeciale == 1) ? 'Yes' : 'No';
        }        
        return $this->partiMatSpeciale;
    }

    /**
     * Get notePartiMatSpeciale
     * 
     * @return string
     */      
    function getNotePartiMatSpeciale()
    {
        return $this->notePartiMatSpeciale;
    }

    /**
     * Get destinazioneUso
     * 
     * @return string
     */      
    function getDestinazioneUso()
    {
        return $this->destinazioneUso;
    }

    /**
     * Get tensione
     * 
     * @return string
     */      
    function getTensione()
    {
        return $this->tensione;
    }

    /**
     * Get frequenza
     * 
     * @return string
     */      
    function getFrequenza()
    {
        return $this->frequenza;
    }

    /**
     * Get potenza
     * 
     * @return string
     */      
    function getPotenza()
    {
        return $this->potenza;
    }

    /**
     * Get spina
     * 
     * @return string
     */      
    function getSpina()
    {
        return $this->spina;
    }

    /**
     * Get cavo
     * 
     * @return string
     */      
    function getCavo()
    {
        return $this->cavo;
    }

    /**
     * Set partiPlastiche
     * 
     * @param string $partiPlastiche
     * @return \Proto\Entity\Proto
     */    
    function setPartiPlastiche($partiPlastiche)
    {
        $this->partiPlastiche = $partiPlastiche;
        return $this;
    }

    /**
     * Set partiLavMetallo
     * 
     * @param string $partiLavMetallo
     * @return \Proto\Entity\Proto
     */       
    function setPartiLavMetallo($partiLavMetallo)
    {
        $this->partiLavMetallo = $partiLavMetallo;
        return $this;
    }

    /**
     * Set partiTrasparenti
     * 
     * @param string $partiTrasparenti
     * @return \Proto\Entity\Proto
     */     
    function setPartiTrasparenti($partiTrasparenti)
    {
        $this->partiTrasparenti = $partiTrasparenti;
        return $this;
    }

    /**
     * Set partiVerniciate
     * 
     * @param string $partiVerniciate
     * @return \Proto\Entity\Proto
     */     
    function setPartiVerniciate($partiVerniciate)
    {
        $this->partiVerniciate = $partiVerniciate;
        return $this;
    }

    /**
     * Set partiGomma
     * 
     * @param string $partiGomma
     * @return \Proto\Entity\Proto
     */     
    function setPartiGomma($partiGomma)
    {
        $this->partiGomma = $partiGomma;
        return $this;
    }

    /**
     * Set partiMatSpeciale
     * 
     * @param string $partiMatSpeciale
     * @return \Proto\Entity\Proto
     */     
    function setPartiMatSpeciale($partiMatSpeciale)
    {
        $this->partiMatSpeciale = $partiMatSpeciale;
        return $this;
    }

    /**
     * Set notePartiMatSpeciale
     * 
     * @param string $notePartiMatSpeciale
     * @return \Proto\Entity\Proto
     */ 
    function setNotePartiMatSpeciale($notePartiMatSpeciale)
    {
        $this->notePartiMatSpeciale = $notePartiMatSpeciale;
        return $this;
    }

    /**
     * Set destinazioneUso
     * 
     * @param string $destinazioneUso
     * @return \Proto\Entity\Proto
     */     
    function setDestinazioneUso($destinazioneUso)
    {
        $this->destinazioneUso = $destinazioneUso;
        return $this;
    }

    /**
     * Set tensione
     * 
     * @param string $tensione
     * @return \Proto\Entity\Proto
     */     
    function setTensione($tensione)
    {
        $this->tensione = $tensione;
        return $this;
    }

    /**
     * Set frequenza
     * 
     * @param string $frequenza
     * @return \Proto\Entity\Proto
     */     
    function setFrequenza($frequenza)
    {
        $this->frequenza = $frequenza;
        return $this;
    }

    /**
     * Set potenza
     * 
     * @param string $potenza
     * @return \Proto\Entity\Proto
     */     
    function setPotenza($potenza)
    {
        $this->potenza = $potenza;
        return $this;
    }

    /**
     * Set spina
     * 
     * @param string $spina
     * @return \Proto\Entity\Proto
     */     
    function setSpina($spina)
    {
        $this->spina = $spina;
        return $this;
    }

    /**
     * Set cavo
     * 
     * @param string $cavo
     * @return \Proto\Entity\Proto
     */        
    function setCavo($cavo)
    {
        $this->cavo = $cavo;
        return $this;
    }
    
    /**
     * Set serigrafie
     * 
     * @param string $serigrafie
     * @return \Proto\Entity\Proto
     */        
    public function setSerigrafie($serigrafie)
    {
        $this->serigrafie = $serigrafie;
        
        return $this;
    }
    
    /**
     * Get serigrafie
     * 
     * @return string
     */       
    public function getSerigrafie($human = false)
    {
        if ($human) {
            return ($this->serigrafie == 1) ? 'Yes' : 'No';
        }        
        return $this->serigrafie;
    }     
    
    /**
     * Set vpp
     * 
     * @param string $vpp
     * @return \Proto\Entity\Proto
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
     * Get varie

     * @return string
     */     
    function getVarie()
    {
        return $this->varie;
    }

    /**
     * Set varie
     * 
     * @param string $varie
     * @return \Proto\Entity\Proto
     */        
    function setVarie($varie)
    {
        $this->varie = $varie;
        return $this;
    }    
    
    /**
     * Get note

     * @return string
     */     
    function getNote()
    {
        return $this->note;
    }

    /**
     * Set note
     * 
     * @param string $note
     * @return \Proto\Entity\Proto
     */        
    function setNote($note)
    {
        $this->note = $note;
        return $this;
    }    
        
 
          
    /**
     * Aggiunge gli allegati.
     * 
     * @param Collection $attachments gli allegati da aggiungere
     * @return \Proto\Entity\Proto
     */
    public function addAttachments(Collection $attachments)
    {
        foreach ($attachments as $row) {
            $row->setProto($this);
            $this->attachments->add($row);
        }
        
        return $this;
    }

    /**
     * Rimuove gli allegati
     * @param Collection $attachments gli allegati da rimuovere
     * @return \Proto\Entity\Proto
     */
    public function removeAttachments(Collection $attachments)
    {
        foreach ($attachments as $row) {
            $row->setProto(null);
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
     * Aggiunge gli forniture.
     * 
     * @param Collection $supplies le forniture da aggiungere
     * @return \Proto\Entity\Proto
     */
    public function addSupplies(Collection $supplies)
    {
        foreach ($supplies as $row) {
            $row->setProto($this);
            $this->supplies->add($row);
        }
        
        return $this;
    }

    /**
     * Rimuove gli le forniture
     * @param Collection $supplies le forniture da rimuovere
     * @return \Proto\Entity\Proto
     */
    public function removeSupplies(Collection $supplies)
    {
        foreach ($supplies as $row) {
            $row->setProto(null);
            $this->supplies->removeElement($row);
        }
        
        return $this;
    }    
    
    public function getSupplies()
    {   
        return $this->supplies;
    }     

    public function addHistory(Collection $history)
    {
        foreach ($history as $row) {
            $row->setProto($this);
            $this->history->add($row);
        }
    }

    /**
     * Rimuove lo storico
     * @param Collection $history lo storico da rimuovere
     * @return \Proto\Entity\Proto
     */
    public function removeHistory(Collection $history)
    {
        foreach ($history as $row) {
            $row->setProto(null);
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
                if ($row->getProtoStatus()->getId() == $type)
                $history[] = $row;
            }
            return $history;
        }
        return $this->history;
    }          

    /**
     * Set status
     *
     * @param \Proto\Entity\Status
     * @return \Proto\Entity\Proto
     */
    public function setStatus(\Proto\Entity\Status $status = null)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return \Proto\Entity\Status 
     */
    public function getStatus()
    {
        return $this->status;
    }  
    
    /**
     * Set family
     *
     * @param \Application\Entity\Family
     * @return \Proto\Entity\Proto
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
     * Set applicant
     *
     * @param \User\Entity\User
     * @return \Proto\Entity\Proto
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
     * @return \Proto\Entity\Proto
     */
    public function setRequestedDeliveryDate(\DateTime $requestedDeliveryDate)
    {
        $this->requestedDeliveryDate = $requestedDeliveryDate;

        return $this;
    }      

    /**
     * Set expectedDeliveryDate
     * 
     * @param \DateTime $expectedDeliveryDate|null
     * @return \Proto\Entity\Proto
     */
    public function setExpectedDeliveryDate($expectedDeliveryDate)
    {
        $this->expectedDeliveryDate = $expectedDeliveryDate;

        return $this;
    }      
    
    /**
     * Get requestedDeliveryDate
     * 
     * @return \DateTime 
     */
    public function getExpectedDeliveryDate()
    {
        return $this->expectedDeliveryDate;
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
     * @return \Proto\Entity\Proto
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
     * @return \Proto\Entity\Proto
     */
    public function setEditDate(\DateTime $createdDate)
    {
        $this->editDate = $createdDate;

        return $this;
    }  
    
    /**
     * Get endDate
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
     * @return \Proto\Entity\Proto
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;

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
    
        $this->setEditDate(new \Datetime());

    }
    
    
}
