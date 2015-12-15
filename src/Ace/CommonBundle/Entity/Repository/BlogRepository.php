<?php

namespace Ace\CommonBundle\Entity\Repository;

use Ace\CommonBundle\Entity\Blog;

class BlogRepository extends AbstractRepository
{
    public function create()
    {
        return new Blog();
    }

    /**
     * @return Blog
     */
    public function findLast()
    {
        $qb = $this->createQueryBuilder('b');
        $qb
            ->setMaxResults(1)
            ->orderBy('b.id', 'desc');

        $result = $qb->getQuery()->getResult();

        return reset($result);
    }
}
