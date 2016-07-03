<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Schedule;
use Doctrine\ORM\EntityRepository;

/**
 * Schedule Repository
 *
 * @author Yevgeniy Zholkevskiy <zhenya.zholkevskiy@gmail.com>
 */
class ScheduleRepository extends EntityRepository
{
    /**
     * Find schedule with pagination
     *
     * @param int $limit  Limit
     * @param int $offset Offset
     *
     * @return Schedule[]
     */
    public function findScheduleWithPagination($limit, $offset)
    {
        $qb = $this->createQueryBuilder('s');

        return $qb->setFirstResult($offset)
                  ->setMaxResults($limit)
                  ->getQuery()
                  ->getArrayResult();
    }
}
