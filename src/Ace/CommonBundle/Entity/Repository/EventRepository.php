<?php

namespace Ace\CommonBundle\Entity\Repository;

use Ace\CommonBundle\Entity\Event;

class EventRepository extends AbstractRepository
{
    public function create()
    {
        return new Event();
    }
}
