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

    
}