<?php

namespace Samples\Mapper;

use MainModule\Mapper\Db\BaseDoctrine;

class SampleMapper extends BaseDoctrine
{
    public function findAll() 
    {
        $er = $this->em->getRepository($this->options->getSampleEntityClass());
        return $er->findAll();
    }
    
    public function find($id) 
    {
        $er = $this->em->getRepository($this->options->getSampleEntityClass());
        return $er->find($id);
    }    

    /**
     * Counts how many samples there are in the database
     *
     * @return int
     */
    public function count()
    {
        $query = $this->em->createQueryBuilder();
        $query->select(array('s.id'))
                ->from($this->options->getSampleEntityClass(), 's');
        $result = $query->getQuery()->getResult();
        return count($result);
    }


    public function getSearchQuery($searchString, $orderBy, $order)
    {
        $qb = $this->em->createQueryBuilder();
        $qb->select(array('s'))
                ->from($this->options->getSampleEntityClass(), 's')
                ->innerJoin('s.applicant', 'u')
                ->innerJoin('s.status', 't')
                ->where(
                    $qb->expr()->orX(
                    $qb->expr()->like('s.customer', '?1'), 
                    $qb->expr()->like('s.model', '?1'),
                    $qb->expr()->like('u.displayName', '?1'), 
                    $qb->expr()->like('t.name', '?1') 
                ))   
                ->setParameter(1, '%' .$searchString . '%')
                ->orderBy($orderBy, $order);
        return $qb->getQuery();
    }

    //Rimuovo, fisicamente, anche aventuali files allegati
    public function remove($entity)
    {
        $attachments = $entity->getAttachments();
        foreach ($attachments as $attachment) {
            $location = './public' . $this->options->getAttachmentPath() . $attachment->getFileName();
            unlink($location);
        }
        parent::remove($entity);
    }        
}