<?php

namespace Samples\Mapper;

use MainModule\Mapper\Db\BaseDoctrine;

class AttachmentsMapper extends BaseDoctrine
{
    public function findAll() 
    {
        $er = $this->em->getRepository($this->options->getAttachmentsEntityClass());
        return $er->findAll();
    }

    
}