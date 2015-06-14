<?php

namespace Samples\Entity;

use Doctrine\Common\Collections\ArrayCollection,
    Doctrine\Common\Collections\Collection,
    Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="samples_attachments")
 */
class Attachments
{
    // AttachmentType enum values
    const ATTACHMENT_TYPE_REQUEST = 'richiesta';
    const ATTACHMENT_TYPE_CLASSIFIED = 'evasione'; 

    /**
     * @var int|null
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @var \Samples\Entity\Sample
     *
     * @ORM\ManyToOne(targetEntity="Samples\Entity\Sample", inversedBy="attachments", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="sample_id", nullable=true, referencedColumnName="id")
     * })
     */
    protected $sample; 
    
     
    
    /**
     * @var string|null
     *
     * @ORM\Column(name="file_name", type="string", length=128)
     */
    protected $fileName;
    
    /**
     * @var string
     *
     * @ORM\Column(name="attachment_type", type="string", length=19, nullable=false)
     */
    protected $attachmentType;      

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_date", type="datetime", nullable=false)
     */
    protected $createdDate;

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
     * Set sample
     *
     * @param \Samples\Entity\Sample
     * @return \Samples\Entity\Attachments
     */
    public function setSample(\Samples\Entity\Sample $sample = null)
    {
        $this->sample = $sample;

        return $this;
    }

    /**
     * Get sample
     *
     * @return \Samples\Entity\Sample
     */
    public function getSample()
    {
        return $this->sample;
    }    
    
    /**
     * Get fileName
     * 
     * @return string
     */
    public function getFileName()
    {
        return $this->fileName;
    }
    
    /**
     * Set filename
     * 
     * @param string $filename
     * @return \Samples\Entity\Attachments
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;

        return $this;
    }
    
    static private $attachmentTypeValues = null;
    static public function getAttachmentTypeValues()
    {
    	if (self::$attachmentTypeValues == null) {
    		self::$attachmentTypeValues = array();
    		$oClass = new \ReflectionClass(__NAMESPACE__ . '\Attachments');
    		$classConstants = $oClass->getConstants();
    		$constantPrefix = "ATTACHMENT_TYPE_";
    		foreach ($classConstants as $key => $val) {
    			if (substr($key, 0, strlen($constantPrefix)) === $constantPrefix) {
    				self::$attachmentTypeValues[$val] = $val;
    			}
    		}
    	}
    	return self::$attachmentTypeValues;
    }
    
    /**
     * Set attachmentType
     *
     * @param string $attachmentType
     * @return \Samples\Entity\Attachments
     */
    public function setAttachmentType($attachmentType)
    {
    	if (!in_array($attachmentType, self::getAttachmentTypeValues())) {
    		throw new \InvalidArgumentException(
				sprintf('Invalid value for attachment.attachmentType : %s.', $attachmentType)
    		);
    	}
    	
        $this->attachmentType = $attachmentType;
    
        return $this;
    }    
    
    /**
     * Get attachmentType
     * 
     * @return string
     */
    public function getAttachmetType()
    {
        return $this->attachmentType;
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
     * @return \Samples\Entity\Attachments
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
