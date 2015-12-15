<?php

namespace Ace\CommonBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

abstract class AbstractRepository extends EntityRepository
{
    public function save(array $entities, $flush = false)
    {
        foreach ($entities as $entity) {
            $this->getEntityManager()->persist($entity);
        }

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function delete(array $entities, $flush = false)
    {
        foreach ($entities as $entity) {
            $this->getEntityManager()->remove($entity);
        }

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
