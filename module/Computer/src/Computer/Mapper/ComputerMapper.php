<?php

namespace Computer\Mapper;

use MainModule\Mapper\Db\BaseDoctrine;


class ComputerMapper extends BaseDoctrine
{
    public function findAll() 
    {
        $er = $this->em->getRepository($this->options->getComputerEntityClass());
        return $er->findAll();
    }      
}