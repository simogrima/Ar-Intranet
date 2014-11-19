<?php

namespace Computer\Mapper;

use MainModule\Mapper\Db\BaseDoctrine;
use Computer\Entity\History;

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
    
    public function updateBlocked($entity)
    {
        //Per verificare che ci sino modifiche (che sia cambiato lo stato)
        $uow = $this->em->getUnitOfWork();
        $uow->computeChangeSets();
        $changeset = $uow->getEntityChangeSet($entity);
        
        $hm = $this->getHistoryMapper();
        
        $history = array(
            'computer_id' => $entity->getId(),
            'recipient_id' => 2,
            'edit_by' => 1,
        );
        //se c'è il cambio stato
        if(isset($changeset['status'])) {
            $history['type'] = 4;
        } else {
            $history['type'] = 2;
        }
        $objectManager = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
$hydrator = new DoctrineHydrator(
    $objectManager,
    'Application\Entity\City'
);

$city = new City();        
        
        
        
        var_dump($history);
        $history = $hm->getHydrator()->hydrate($history, new History());
        $hm->insert($history);
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