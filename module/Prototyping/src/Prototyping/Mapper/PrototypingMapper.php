<?php

namespace Prototyping\Mapper;

use MainModule\Mapper\Db\BaseDoctrine;
use Zend\View\Model\ViewModel;

class PrototypingMapper extends BaseDoctrine
{

    public function findAll()
    {
        $er = $this->em->getRepository($this->options->getPrototypingEntityClass());
        return $er->findAll();
    }

    public function find($id)
    {
        $er = $this->em->getRepository($this->options->getPrototypingEntityClass());
        return $er->find($id);
    }

    /**
     * Counts how many Prototyping there are in the database
     *
     * @return int
     */
    public function count()
    {
        $query = $this->em->createQueryBuilder();
        $query->select(array('p.id'))
                ->from($this->options->getPrototypingEntityClass(), 'p');
        $result = $query->getQuery()->getResult();
        return count($result);
    }
    
    public function getFieldsSearchQuery($data, $orderBy, $order)
    {
        $qb = $this->em->createQueryBuilder();
        $qb->select(array('p'))
                ->from($this->options->getPrototypingEntityClass(), 'p')
                ->innerJoin('p.status', 't')
                ->innerJoin('p.family', 'f')
                ->orderBy($orderBy, $order);

        if (!empty($data)) {
            $whereString = '';
            $and = '';            
            foreach ($data as $key => $value) {
                switch ($key) {
                    case 'status':
                        $whereString .= $and . "t.id = ?1";
                        $qb->setParameter(1,  trim($value));
                        break;
                    case 'family':
                        $whereString .= $and . "f.id = ?2";
                        $qb->setParameter(2,  trim($value));
                        break;                    
                    case 'id':
                        $whereString .= $and . "p.id = ?3";
                        $qb->setParameter(3,  trim($value));
                        break;                    
                    default:
                        $whereString .= $and . "p.$key LIKE :$key";
                        $qb->setParameter($key, '%' . trim($value) . '%');
                        break;
                }
                $and = ' AND ';                
            }
            $qb->where($whereString);
        }
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
