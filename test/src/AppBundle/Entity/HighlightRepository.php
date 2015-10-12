<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * HighlightRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class HighlightRepository extends EntityRepository
{

    public function findHighlight($id) {

        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('h')
            ->from('AppBundle:Highlight', 'h')
            ->where('h.user = :id')
            ->setParameter('id', $id)
            ->getQuery();
        $query = $qb->getQuery();
        $result = $query->getResult();

        return $result;
    }

    public function findHighlightWithDate($user, $start_date, $end_date) {

        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('h')
            ->from('AppBundle:Highlight', 'h')
            ->join('h.testgame', 't')
            ->where($qb->expr()->between(
                't.gamedates',
                ':from',
                ':to'
            ))
            ->andWhere('h.user = :id')
            ->orderBy('t.gamedates', 'ASC')
            ->setParameters(array(
                'id' => $user,
                'from' => $start_date,
                'to' => $end_date,
            ));

        return $qb->getQuery()->getResult();

    }
    public function findHighlightJson($user, $start_date, $end_date) {

        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('h')
            ->from('AppBundle:Highlight', 'h')
            ->join('h.testgame', 't')
            ->where($qb->expr()->between(
                't.gamedates',
                ':from',
                ':to'
            ))
            ->andWhere('h.user = :id')
            ->orderBy('t.gamedates', 'ASC')
            ->setParameters(array(
                'id' => $user,
                'from' => $start_date,
                'to' => $end_date,
            ));

        return $qb->getQuery()->getArrayResult();

    }
}