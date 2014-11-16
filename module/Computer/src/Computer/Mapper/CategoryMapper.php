<?php

namespace Computer\Mapper;

use MainModule\Mapper\Db\BaseDoctrine;

class CategoryMapper extends BaseDoctrine
{
    public function findAll() 
    {
        $er = $this->em->getRepository($this->options->getCategoryEntityClass());
        return $er->findAll();
    }

    
}