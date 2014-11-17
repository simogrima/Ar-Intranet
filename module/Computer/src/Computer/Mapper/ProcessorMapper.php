<?php

namespace Computer\Mapper;

use MainModule\Mapper\Db\BaseDoctrine;

class ProcessorMapper extends BaseDoctrine
{
    public function findAll() 
    {
        $er = $this->em->getRepository($this->options->getProcessorEntityClass());
        return $er->findAll();
    }

    
}