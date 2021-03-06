<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * MessagesRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class MessagesRepository extends EntityRepository
{

    public function getLatestMessage() {

        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('m')
            ->from('AppBundle:Messages', 'm')
            ->orderBy('m.date', 'DESC')
            ->setMaxResults(1)
            ->getQuery();
        $query = $qb->getQuery();
        $latest_message = $query->getResult();

        return $latest_message;

    }

    public function getLatestFiveMessage() {

        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('m')
            ->from('AppBundle:Messages', 'm')
            ->orderBy('m.date', 'DESC')
            ->setMaxResults(5)
            ->getQuery();
        $query = $qb->getQuery();
        $latest_five_message = $query->getResult();

        return $latest_five_message;

    }

    public function getJsonMessages()
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('m')
            ->from('AppBundle:Messages', 'm')
            ->orderBy('m.date', 'DESC')
            ->getQuery();
        return $qb->getQuery()->getArrayResult();
    }


}
