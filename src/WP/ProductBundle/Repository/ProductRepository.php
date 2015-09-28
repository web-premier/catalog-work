<?php

namespace WP\ProductBundle\Repository;

/**
 * ProductRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProductRepository extends \Doctrine\ORM\EntityRepository
{
    public function getInCart($ids)
    {
        return $this->createQueryBuilder('p')
            ->where('p.id IN (:ids)')
            ->setParameter('ids', array_values($ids))
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

        $qb = $this->createQueryBuilder('p');

        if($start){
            $qb->andWhere('p.updatedAt >= :start')
                ->setParameter('start',new \DateTime($start));
        }

        if($end){
            $qb->andWhere('p.updatedAt <= :end')
                ->setParameter('end',new \DateTime($end));
        }

        return $qb->getQuery()
            ->getResult();
    }
}
