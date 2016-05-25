<?php

namespace Proto\Options;

use Zend\Stdlib\AbstractOptions;

class ModuleOptions extends AbstractOptions
{

    /**
     * @var string
     */
    protected $protoEntityClass = 'Proto\Entity\Proto';
    protected $attachmentsEntityClass = 'Proto\Entity\Attachments';    
    protected $historyEntityClass = 'Proto\Entity\History'; 
    protected $suppliesEntityClass = 'Proto\Entity\Supplies';

    /**
     * set proto entity class name
     *
     * @param string $entityClass
     * @return ModuleOptions
     */
    public function setProtoEntityClass($entityClass)
    {
        $this->protoClassEntityClass = $entityClass;
        return $this;
    }

    /**
     * get proto entity class name
     *
     * @return string
     */
    public function getProtoEntityClass()
    {
        return $this->protoEntityClass;
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
     * set supplies entity class name
     *
     * @param string $entityClass
     * @return ModuleOptions
     */
    public function setSuppliesEntityClass($entityClass)
    {
        $this->suppliesEntityClass = $entityClass;
        return $this;
    }

    /**
     * get supplies entity class name
     *
     * @return string
     */
    public function getSuppliesEntityClass()
    {
        return $this->suppliesEntityClass;
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
    

     /**
     * Getter indirizzi x notifica (email) nuova richiesta
     * 
     * @return array
     */
    function getEmailToNewRequest()
    {
        return $this->emailToNewRequest;
    }
    
    /**
     * Setter indirizzi x notifica (email) nuova richiesta
     * 
     * @param array $emails
     * @return ModuleOptions
     */
    function setEmailToNewRequest(array $emails)
    {
        $this->emailToNewRequest = $emails;
        return $this;
    }       
 
    
  
        
}
