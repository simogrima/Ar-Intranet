<?php

namespace Application\Mapper;

use MainModule\Mapper\Db\BaseDoctrine;

class SuppliersMapper extends BaseDoctrine
{

    public function findAll()
    {
        $er = $this->em->getRepository($this->options->getSuppliersEntityClass());
        return $er->findAll();
    }


    public function getSearchQuery($searchString, $orderBy, $order)
    {
        $qb = $this->em->createQueryBuilder();
        $qb->select(array('s'))
                ->from($this->options->getSuppliersEntityClass(), 's')
                ->where(
                    $qb->expr()->orX(
                    $qb->expr()->like('s.companyName', '?1'), 
                    $qb->expr()->like('s.status', '?1')
                ))   
                ->setParameter(1, '%' .$searchString . '%')
                ->orderBy($orderBy, $order);
        return $qb->getQuery();
    }     
}
