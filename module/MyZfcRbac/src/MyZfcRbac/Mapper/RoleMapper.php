<?php

namespace MyZfcRbac\Mapper;

use ZfcUserDoctrineORM\Mapper\User as ZfcUserDoctrineMapper;
use MainModule\Mapper\Db\BaseDoctrine;

class RoleMapper extends BaseDoctrine
{
    public function findAll() 
    {
        $er = $this->em->getRepository($this->options->getRoleEntityClass());
        return $er->findAll();
    }

    
}