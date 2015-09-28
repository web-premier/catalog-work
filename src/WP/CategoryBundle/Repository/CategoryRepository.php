<?php

namespace WP\CategoryBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * CategoryRepository
 */
class CategoryRepository extends EntityRepository
{
    /**
     * Get all main categories
     *
     * @return array
     */
    public function getMainCategories()
    {
        return $this->createQueryBuilder('category')
            ->select(['category', 'children'])
            ->leftJoin('category.children', 'children')
            ->where('category.parent IS NULL')
            ->getQuery()
            ->getResult();
    }

    /**
     * Get from API.
     *
     * @return array
     */
    public function findFromApi($start,$end)
    {

        $qb = $this->createQueryBuilder('c');

        if($start){
            $qb->andWhere('c.updatedAt >= :start')
                ->setParameter('start',new \DateTime($start));
        }

        if($end){
            $qb->andWhere('c.updatedAt <= :end')
                ->setParameter('end',new \DateTime($end));
        }

        return $qb->getQuery()
            ->getResult();
    }
}
