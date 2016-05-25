<?php

namespace Proto\Mapper;

use MainModule\Mapper\Db\BaseDoctrine;

class AttachmentsMapper extends BaseDoctrine
{
    public function findAll() 
    {
        $er = $this->em->getRepository($this->options->getAttachmentsEntityClass());
        return $er->findAll();
    }
    
    public function getSearchQuery($searchString, $orderBy, $order)
    {
        $qb = $this->em->createQueryBuilder();
        $qb->select(array('a'))
                ->from($this->options->getAttachmentsEntityClass(), 'a')
                ->innerJoin('a.proto', 's')
                ->where(
                    $qb->expr()->orX(
                    $qb->expr()->like('a.fileName', '?1'), 
                    $qb->expr()->like('s.id', '?1')
                ))   
                ->setParameter(1, '%' .$searchString . '%')
                ->orderBy($orderBy, $order);
        return $qb->getQuery();
    }    

    //Rimuovo, fisicamente, anche file
    public function remove($entity)
    {
        $location = './public' . $this->options->getAttachmentPath() . $entity->getFileName();
        unlink($location);

        parent::remove($entity);
    }         
}