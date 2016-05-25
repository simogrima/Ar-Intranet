<?php

namespace Proto\Mapper;

use MainModule\Mapper\Db\BaseDoctrine;

class SuppliesMapper extends BaseDoctrine
{

    public function findAll()
    {
        $er = $this->em->getRepository($this->options->getSuppliesEntityClass());
        return $er->findAll();
    }
    
    public function find($id)
    {
        $er = $this->em->getRepository($this->options->getSuppliesEntityClass());
        return $er->find($id);
    }    


    public function getSearchQuery($searchString, $orderBy, $order)
    {
        $qb = $this->em->createQueryBuilder();
        $qb->select(array('s'))
                ->from($this->options->getSuppliesEntityClass(), 's')
                ->innerJoin('s.supplier', 'su')
                ->where(
                    $qb->expr()->orX(
                    $qb->expr()->like('s.orderNr', '?1'), 
                    $qb->expr()->like('su.companyName', '?2')
                ))   
                ->setParameter(1, '%' .$searchString . '%')
                ->setParameter(2, '%' .$searchString . '%')
                ->orderBy($orderBy, $order);
        return $qb->getQuery();
    }       
}
