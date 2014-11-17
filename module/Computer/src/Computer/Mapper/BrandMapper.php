<?php

namespace Computer\Mapper;

use MainModule\Mapper\Db\BaseDoctrine;

class BrandMapper extends BaseDoctrine
{
    public function findAll() 
    {
        $er = $this->em->getRepository($this->options->getBrandEntityClass());
        return $er->findAll();
    }

    
}