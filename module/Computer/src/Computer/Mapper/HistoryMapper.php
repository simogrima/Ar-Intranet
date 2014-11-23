<?php

namespace Computer\Mapper;

use MainModule\Mapper\Db\BaseDoctrine;

class HistoryMapper extends BaseDoctrine
{
    public function findAll() 
    {
        $er = $this->em->getRepository($this->options->getHistoryEntityClass());
        return $er->findAll();
    }

    public function findAllByComputerId($computerId)
    {
        $er = $this->em->getRepository($this->options->getHistoryEntityClass());
        $er->findBy("first_name", "Travis");
    }        
    
}