<?php

namespace Samples\Options;

use Zend\Stdlib\AbstractOptions;

class ModuleOptions extends AbstractOptions
{

    /**
     * @var string
     */
    protected $sampleEntityClass = 'Samples\Entity\Sample';
    protected $attachmentsEntityClass = 'Samples\Entity\Attachments';    
    protected $historyEntityClass = 'Samples\Entity\History'; 

    /**
     * set sample entity class name
     *
     * @param string $entityClass
     * @return ModuleOptions
     */
    public function setSampleEntityClass($entityClass)
    {
        $this->sampleClassEntityClass = $entityClass;
        return $this;
    }

    /**
     * get sample entity class name
     *
     * @return string
     */
    public function getSampleEntityClass()
    {
        return $this->sampleEntityClass;
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
    
    /**
     * Getter indirizzi x notifica (email) nuovo campione
     * 
     * @return array
     */
    function getEmailToNewSample()
    {
        return $this->emailToNewSample;
    }
    
    /**
     * Setter indirizzi x notifica (email) nuovo campione
     * 
     * @param array $emails
     * @return \Samples\Options\ModuleOptions
     */
    function setEmailToNewSample(array $emails)
    {
        $this->emailToNewSample = $emails;
        return $this;
    }    
    
    /**
     * Getter indirizzi x notifica (email) campione evaso
     * 
     * @return array
     */
    function getEmailToProcessedSample()
    {
        return $this->emailToProcessedSample;
    }
    
    /**
     * Setter indirizzi x notifica (email) campione evaso
     * 
     * @param array $emails
     * @return \Samples\Options\ModuleOptions
     */
    function setEmailToProcessedSample(array $emails)
    {
        $this->emailToProcessedSample = $emails;
        return $this;
    }        
    
    /**
     * Getter indirizzi x notifica (email) spedizione pronta
     * 
     * @return array
     */
    function getEmailToShippingReady()
    {
        return $this->emailToShippingReady;
    }
    
    /**
     * Setter indirizzi x notifica (email) spedizione pronta
     * 
     * @param array $emails
     * @return \Samples\Options\ModuleOptions
     */
    function setEmailToShippingReady(array $emails)
    {
        $this->emailToShippingReady = $emails;
        return $this;
    }       
    
}
