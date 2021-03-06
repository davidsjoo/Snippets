<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * TestgameRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TestgameRepository extends EntityRepository
{
    public function findGames() 
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('t','c', 'h', 'g')
            ->from('AppBundle:Testgame', 't')
            ->join('t.highlight', 'h')
            ->join('t.cmh', 'c')
            ->join('t.grade', 'g')
            ->where('t.gamedates > :today')
            ->orderBy('t.gamedates', 'ASC')
            ->setParameter('today', new \DateTime('2014-12-24'))
            ->getQuery();
        return $qb->getQuery()->getResult();
    }

    public function findPlayedGames() 
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('t', 'h', 'c', 'g')
            ->from('AppBundle:Testgame', 't')
            ->join('t.highlight', 'h')
            ->join('t.cmh', 'c')
            ->join('t.grade', 'g')
            ->where('t.gamedates < :today')
            ->orderBy('t.gamedates', 'ASC')
            ->setParameter('today', new \DateTime('today'))
            ->getQuery();
        return $qb->getQuery()->getResult();
    }

    public function findMyGames() 
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('t', 'h', 'c', 'g')
            ->from('AppBundle:Testgame', 't')
            ->join('t.highlight', 'h')
            ->join('t.cmh', 'c')
            ->join('t.grade', 'g')
            ->where('h.user = :user')
            ->orWhere('c.user = :user')
            ->orderBy('t.gamedates', 'ASC')
            ->setParameter('user', 1);
        return $qb->getQuery()->getResult();
    }

    public function findTradeGames()
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('t', 'h', 'c', 'u')
            ->from('AppBundle:Testgame', 't')
            ->join('t.highlight', 'h')
            ->join('t.cmh', 'c')
            ->join('h.user', 'u')
            ->where('h.trade = :true')
            ->andWhere('h.accepted_trade = :false') 
            ->orderBy('t.gamedates', 'ASC')
            ->setParameters(array(
                'true' => true,
                'false' => false,
                ));
        return $qb->getQuery()->getResult();
    }

    public function findGamesByUserAndDate($user, $start_date, $end_date) 
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('t')
            ->from('AppBundle:Testgame', 't')
            ->join('t.highlight', 'h')
            ->where($qb->expr()->between(
                't.gamedates',
                ':from',
                ':to'
            ))
            ->andWhere('h.user = :user')
            ->setParameters(array(
                'user' => $user,
                'from' => $start_date,
                'to' => $end_date,
            ));

        return $qb->getQuery()->getArrayResult();
    }

    public function findHighlightByUserAndDateJson($user, $start_date, $end_date) 
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('t')
            ->from('AppBundle:Testgame', 't')
            ->join('t.highlight', 'h')
            ->where($qb->expr()->between(
                't.gamedates',
                ':from',
                ':to'
            ))
            ->andWhere('h.user = :user')
            ->orderBy('t.gamedates', 'ASC')
            ->setParameters(array(
                'user' => $user,
                'from' => $start_date,
                'to' => $end_date,
            ));

        return $qb->getQuery()->getArrayResult();
    }

    public function findCmhByUserAndDateJson($user, $start_date, $end_date) 
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('t')
            ->from('AppBundle:Testgame', 't')
            ->join('t.cmh', 'c')
            ->where($qb->expr()->between(
                't.gamedates',
                ':from',
                ':to'
            ))
            ->andWhere('c.user = :user')
            ->orderBy('t.gamedates', 'ASC')
            ->setParameters(array(
                'user' => $user,
                'from' => $start_date,
                'to' => $end_date,
            ));

        return $qb->getQuery()->getArrayResult();
    }

    public function findGamesJson()
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('t')
            ->from('AppBundle:Testgame', 't')
            ->where('t.gamedates > :today')
            ->orderBy('t.gamedates', 'ASC')
            ->setParameter('today', new \DateTime('today'))
            ->getQuery();
        return $qb->getQuery()->getArrayResult();
    }

    public function findHighlightJson($id) 
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('t')
            ->from('AppBundle:Testgame', 't')
            ->where('t.id = :id')
            ->setParameter('id', $id)
            ->getQuery();
        return $qb->getQuery()->getArrayResult();
    }
}
