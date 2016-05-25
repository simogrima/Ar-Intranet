<?php

namespace Prototyping\Options;

use Zend\Stdlib\AbstractOptions;

class ModuleOptions extends AbstractOptions
{

    /**
     * @var string
     */
    protected $prototypingEntityClass = 'Prototyping\Entity\Prototyping';
    protected $attachmentsEntityClass = 'Prototyping\Entity\Attachments';    
    protected $historyEntityClass = 'Prototyping\Entity\History'; 

    /**
     * set prototyping entity class name
     *
     * @param string $entityClass
     * @return ModuleOptions
     */
    public function setPrototypingEntityClass($entityClass)
    {
        $this->prototypingClassEntityClass = $entityClass;
        return $this;
    }

    /**
     * get prototyping entity class name
     *
     * @return string
     */
    public function getPrototypingEntityClass()
    {
        return $this->prototypingEntityClass;
    }
    
    /**
     * set Attachments entity class name
     *
     * @param string $entityClass
     * @return ModuleOptions
     */
    public function setAttachmentsEntityClass($entityClass)
    {
        $this->attachmentsEntityClass = $entityClass;
        return $this;
    }

    /**
     * get Attachments entity class name
     *
     * @return string
     */
    public function getAttachmentsEntityClass()
    {
        return $this->attachmentsEntityClass;
    }    
    
    /**
     * set history entity class name
     *
     * @param string $entityClass
     * @return ModuleOptions
     */
    public function setHistoryEntityClass($entityClass)
    {
        $this->historyEntityClass = $entityClass;
        return $this;
    }

    /**
     * get history entity class name
     *
     * @return string
     */
    public function getHistoryEntityClass()
    {
        return $this->historyEntityClass;
    }      

    /**
     * Getter path allegati
     * @return string
     */
    function getAttachmentPath()
    {
        return $this->attachmentPath;
    }

    /**
     * Setter path allegati
     * 
     * @param string $path
     */
    function setAttachmentPath($path)
    {
        $this->attachmentPath = $path;
    }   
    

     
 
    
  
        
}
