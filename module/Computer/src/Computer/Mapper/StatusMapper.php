<?php

namespace Computer\Mapper;

use MainModule\Mapper\Db\BaseDoctrine;

class StatusMapper extends BaseDoctrine
{
    public function findAll() 
    {
        $er = $this->em->getRepository($this->options->getStatusEntityClass());
        return $er->findAll();
    }

    
}