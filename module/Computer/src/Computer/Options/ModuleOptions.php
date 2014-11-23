<?php

namespace Computer\Options;

use Zend\Stdlib\AbstractOptions;

class ModuleOptions extends AbstractOptions
{

    /**
     * @var string
     */
    protected $computerEntityClass = 'Computer\Entity\Computer';
    protected $statusEntityClass = 'Computer\Entity\Status';    
    protected $categoryEntityClass = 'Computer\Entity\Category'; 
    protected $brandEntityClass = 'Computer\Entity\Brand'; 
    protected $processorEntityClass = 'Computer\Entity\Processor'; 
    protected $historyEntityClass = 'Computer\Entity\History'; 
    protected $scortaId;
    protected $scortaUserId;

    /**
     * set computer entity class name
     *
     * @param string $entityClass
     * @return ModuleOptions
     */
    public function setComputerEntityClass($entityClass)
    {
        $this->computerClassEntityClass = $entityClass;
        return $this;
    }

    /**
     * get computer entity class name
     *
     * @return string
     */
    public function getComputerEntityClass()
    {
        return $this->computerEntityClass;
    }
    
    /**
     * set status entity class name
     *
     * @param string $entityClass
     * @return ModuleOptions
     */
    public function setStatusEntityClass($entityClass)
    {
        $this->statusEntityClass = $entityClass;
        return $this;
    }

    /**
     * get status entity class name
     *
     * @return string
     */
    public function getStatusEntityClass()
    {
        return $this->statusEntityClass;
    }
    
    /**
     * set category entity class name
     *
     * @param string $entityClass
     * @return ModuleOptions
     */
    public function setCategoryEntityClass($entityClass)
    {
        $this->categoryEntityClass = $entityClass;
        return $this;
    }

    /**
     * get category entity class name
     *
     * @return string
     */
    public function getCategoryEntityClass()
    {
        return $this->categoryEntityClass;
    }    
    
    /**
     * set brand entity class name
     *
     * @param string $entityClass
     * @return ModuleOptions
     */
    public function setBrandEntityClass($entityClass)
    {
        $this->brandEntityClass = $entityClass;
        return $this;
    }

    /**
     * get brand entity class name
     *
     * @return string
     */
    public function getBrandEntityClass()
    {
        return $this->brandEntityClass;
    }  
    
    /**
     * set processor entity class name
     *
     * @param string $entityClass
     * @return ModuleOptions
     */
    public function setProcessorEntityClass($entityClass)
    {
        $this->processorEntityClass = $entityClass;
        return $this;
    }

    /**
     * get processor entity class name
     *
     * @return string
     */
    public function getProcessorEntityClass()
    {
        return $this->processorEntityClass;
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
     * Get scorta Id
     * 
     * @return int
     */
    function getScortaId()
    {
        return $this->scortaId;
    }

    /**
     * Get id utente a cui saranno assegnati i computers in scorta
     * @return int
     */
    function getScortaUserId()
    {
        return $this->scortaId;
    }

    /**
     * Set scorta Id
     * 
     * @param int $scortaId
     */
    function setScortaId($scortaId)
    {
        $this->scortaId = $scortaId;
    }

    /**
     * Set id utente a cui saranno assegnati i computers in scorta
     * @param int $userScortaId
     */
    function setScortaUserId($scortaUserId)
    {
        $this->scortaUserId = $scortaUserId;
    }



}
