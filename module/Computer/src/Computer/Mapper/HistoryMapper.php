<?php

namespace Computer\Mapper;

use MainModule\Mapper\Db\BaseDoctrine;
use Computer\Entity\Computer;

class HistoryMapper extends BaseDoctrine
{

    public function findAll()
    {
        $er = $this->em->getRepository($this->options->getHistoryEntityClass());
        return $er->findAll();
    }

    /**
     * 
     * @param Computer $computer
     */
    public function resetStatusByComputerId(Computer $computer)
    {
        $qb = $this->em->createQueryBuilder();
        $q = $qb->update($this->options->getHistoryEntityClass(), 'h')
                ->set('h.status', '?1')
                ->where('h.computer = ?2')
                ->setParameter(1, 0)
                ->setParameter(2, $computer)
                ->getQuery();
        $p = $q->execute();
    }

}
