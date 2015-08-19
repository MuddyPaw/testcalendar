<?php


namespace AppBundle\Repository;

use AppBundle\Entity\Event;
use Doctrine\ORM\EntityRepository;


class EventRepository extends AbstractRepository
{


    public function getEventsThatStartBetween($startTime, $endTime)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        return $qb->select('e')
            ->from(Event::ENTITY_PATH, 'e')
            ->andWhere($qb->expr()->between('e.startTime', ':startTime', ':endTime'))
            ->setParameter('startTime', $startTime)
            ->setParameter('endTime', $endTime)
            ->getQuery()
            ->getResult();
    }


}
