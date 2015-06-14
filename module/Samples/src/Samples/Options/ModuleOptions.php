<?php

namespace Samples\Options;

use Zend\Stdlib\AbstractOptions;

class ModuleOptions extends AbstractOptions
{

    /**
     * @var string
     */
    protected $sampleEntityClass = 'Samples\Entity\Sample';
    
    /**
     * @var string
     */
    protected $attachmentsEntityClass = 'Samples\Entity\Attachments';    

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

}
