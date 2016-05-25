<?php

namespace Prototyping\Entity;

use Doctrine\Common\Collections\ArrayCollection,
    Doctrine\Common\Collections\Collection,
    Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="prototyping_attachments")
 */
class Attachments
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
     * @var \Prototyping\Entity\Prototyping
     *
     * @ORM\ManyToOne(targetEntity="Prototyping\Entity\Prototyping", inversedBy="attachments", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="prototyping_id", nullable=true, referencedColumnName="id")
     * })
     */
    protected $prototyping; 
    
     
    
    /**
     * @var string|null
     *
     * @ORM\Column(name="file_name", type="string", length=128)
     */
    protected $fileName;   

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
     * Set prototyping
     *
     * @param \Prototyping\Entity\Prototyping
     * @return \Prototyping\Entity\Attachments
     */
    public function setPrototyping(\Prototyping\Entity\Prototyping $prototyping = null)
    {
        $this->prototyping = $prototyping;

        return $this;
    }

    /**
     * Get Prototyping
     *
     * @return \Prototyping\Entity\Prototyping
     */
    public function getPrototyping()
    {
        return $this->prototyping;
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
     * @return \Prototyping\Entity\Attachments
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;

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
     * @return \Prototyping\Entity\Attachments
     */
    public function setCreatedDate(\DateTime $createdDate)
    {
        $this->createdDate = $createdDate;

        return $this;
    }    
    
    /**
     * Metodo puramente logico che in base all'estensione del file restituisce 
     * il nome dell'icona.
     * @return string
     */
    public function getIcon()
    {
        $pos = strrpos($this->getFileName(), '.');
        $extension = substr($this->getFileName(), $pos+1);
        switch (strtolower($extension)) {
            case 'jpg':
            case 'jpeg':
            case 'gif':    
                return 'image.png';
                break;
            case 'png':    
                return 'png.png';
                break;
            case 'doc':
            case 'docx':    
                return 'word.png';
                break; 
            case 'xls':
            case 'xlsx':    
                return 'excel.png';
                break;       
            case 'ppt':
            case 'pptx':    
                return 'pp.png';
                break;    
            case 'pdf':    
                return 'pdf.png';
                break;  
            case 'ai':    
                return 'ai.png';
                break;    
            case 'psd':    
                return 'psd.png';
                break;
            case 'webm':
            case 'flv':
            case 'avi':    
            case 'mp4': 
            case 'wmv': 
            case 'mov': 
                return 'video.png';
                break;            
            default:
                return 'generic.png';
                break;
        }
    }        
    
    /**
     * Metodo puramente logico che in base all'estensione del file dice se è un'immagine 
     * 
     * @return boolean
     */
    public function isImage()
    {
        $pos = strrpos($this->getFileName(), '.');
        $extension = strtolower(substr($this->getFileName(), $pos+1));
        
        $ok = ['jpg','jpeg','gif','png','bmp','tiff'];
        
        return (in_array($extension, $ok));
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
