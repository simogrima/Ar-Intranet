<?php

namespace Samples\Mapper;

use MainModule\Mapper\Db\BaseDoctrine;

class SampleMapper extends BaseDoctrine
{
    public function findAll() 
    {
        $er = $this->em->getRepository($this->options->getSampleEntityClass());
        return $er->findAll();
    }

    
}