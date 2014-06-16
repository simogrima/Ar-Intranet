<?php

namespace MyZfcRbac\Mapper;

use ZfcUserDoctrineORM\Mapper\User as ZfcUserDoctrineMapper;
use MainModule\Mapper\Db\BaseDoctrine;

class PermissionMapper extends BaseDoctrine
{
    public function findAll() 
    {
        $er = $this->em->getRepository($this->options->getpermissionEntityClass());
        return $er->findAll();
    }

    
}