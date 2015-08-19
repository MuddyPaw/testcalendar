<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

abstract class AbstractRepository extends EntityRepository
{

    /**
     * Persists an entity
     * @param Obj $entity
     */
    public function persist($entity)
    {
        return $this->getEntityManager()->persist($entity);
    }

    public function flush()
    {
        $this->getEntityManager()->flush();
    }

    public function clear()
    {
        $this->getEntityManager()->clear();
    }

    /**
     * Save a entity to the database
     * @param Obj $entity
     */
    public function save($entity)
    {
        $this->persist($entity);
        $this->getEntityManager()->flush();
    }

    /**
     * Adds a entity to the database
     * @param Obj $entity
     */
    public function add($entity)
    {
        $this->persist($entity);
        $this->getEntityManager()->flush();
    }

    /**
     * Removes a entity from the database
     * @param Obj $entity
     */
    public function remove($entity)
    {
        $this->getEntityManager()->remove($entity);
        $this->flush();
    }

}
