<?php

namespace Computer\Mapper;

use MainModule\Mapper\Db\BaseDoctrine;

class ComputerMapper extends BaseDoctrine
{
    /**
     * @var \Computer\Mapper\HistoryMapper;
     */
    protected $historyMapper;
    
    public function findAll() 
    {
        $er = $this->em->getRepository($this->options->getComputerEntityClass());
        return $er->findAll();
    }    
    
    public function update($entity)
    {
        //Per verificare che ci sino modifiche (che sia cambiato lo stato)
        $uow = $this->em->getUnitOfWork();
        $uow->computeChangeSets();
        $changeset = $uow->getEntityChangeSet($entity);
        
        $hm = $this->getHistoryMapper();
        
        //se c'è il cambio stato
        if(isset($changeset['status'])) {
            echo 'cambio stato';
        } else {
            
        }
        
        return $this->persist($entity);   
    }   
    
    /**
     * Getter HistoryMapper
     * 
     * @return \Computer\Mapper\HistoryMapper
     */
    function getHistoryMapper()
    {
        return $this->historyMapper;
    }

    /**
     * Setter HistoryMapper
     * 
     * @param \Computer\Mapper\HistoryMapper $historyMapper
     * @return \Computer\Mapper\ComputerMapper
     */
    function setHistoryMapper(\Computer\Mapper\HistoryMapper $historyMapper)
    {
        $this->historyMapper = $historyMapper;
        
        return $this;
    }


    
    
}