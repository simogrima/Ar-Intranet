<?php

namespace Proto\Mapper;

use MainModule\Mapper\Db\BaseDoctrine;

class HistoryMapper extends BaseDoctrine
{

    public function findAll()
    {
        $er = $this->em->getRepository($this->options->getHistoryEntityClass());
        return $er->findAll();
    }

    /**
     * Per ora molto semplice serve solo per paginatore
     * ritorna tutti i records senza parametri ricerca
     * @return type
     */
    public function getSearchQuery()
    {
        $qb = $this->em->createQueryBuilder();
        $qb->select(array('h'))
                ->from($this->options->getHistoryEntityClass(), 'h');
        return $qb->getQuery();
    }
}
