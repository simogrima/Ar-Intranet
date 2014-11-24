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

    /**
     * Returns a list of computers
     *
     * @param int $offset Offset
     * @param int $itemCountPerPage Max results
     *
     * @return array
     */
    public function getItems($offset, $itemCountPerPage)
    {
        $query = $this->em->createQueryBuilder();
        $query->select(array('c'))
                ->from($this->options->getComputerEntityClass(), 'c')
                ->setFirstResult($offset)
                ->setMaxResults($itemCountPerPage);
        $result = $query->getQuery()->getResult(Query::HYDRATE_OBJECT);
        return $result;
    }

    public function getSearchQuery($searchString)
    {
        $qb = $this->em->createQueryBuilder();
        $qb->select(array('c'))
                ->from($this->options->getComputerEntityClass(), 'c')
                ->innerJoin('c.status', 's')
                ->innerJoin('c.brand', 'b')
                ->innerJoin('c.processor', 'p')
                ->where(
                    $qb->expr()->orX(
                    $qb->expr()->like('c.serial', '?1'), 
                    $qb->expr()->like('c.model', '?1'),
                    $qb->expr()->like('s.name', '?1'),   
                    $qb->expr()->like('b.name', '?1'),
                    $qb->expr()->like('p.name', '?1') 
                ))   
                ->setParameter(1, '%' .$searchString . '%')
                ->orderBy('c.id', 'DESC');
        return $qb->getQuery();
    }

}
