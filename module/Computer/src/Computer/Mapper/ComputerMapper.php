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
}