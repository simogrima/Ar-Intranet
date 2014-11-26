<?php

namespace Computer\Mapper;

use MainModule\Mapper\Db\BaseDoctrine;
use Doctrine\ORM\Query;

class ComputerMapper extends BaseDoctrine
{

    public function findAll()
    {
        $er = $this->em->getRepository($this->options->getComputerEntityClass());
        return $er->findAll();
    }

    /**
     * Counts how many computers there are in the database
     *
     * @return int
     */
    public function count()
    {
        $query = $this->em->createQueryBuilder();
        $query->select(array('c.id'))
                ->from($this->options->getComputerEntityClass(), 'c');
        $result = $query->getQuery()->getResult();
        return count($result);
    }


    public function getSearchQuery($searchString, $orderBy, $order)
    {
        $qb = $this->em->createQueryBuilder();
        $qb->select(array('c'))
                ->from($this->options->getComputerEntityClass(), 'c')
                ->innerJoin('c.status', 's')
                ->innerJoin('c.brand', 'b')
                ->innerJoin('c.processor', 'p')
                ->innerJoin('c.recipient', 'u')
                ->where(
                    $qb->expr()->orX(
                    $qb->expr()->like('c.serial', '?1'), 
                    $qb->expr()->like('c.model', '?1'),
                    $qb->expr()->like('s.name', '?1'),   
                    $qb->expr()->like('b.name', '?1'),
                    $qb->expr()->like('p.name', '?1'), 
                    $qb->expr()->like('u.displayName', '?1') 
                ))   
                ->setParameter(1, '%' .$searchString . '%')
                ->orderBy($orderBy, $order);
        return $qb->getQuery();
    }

}
