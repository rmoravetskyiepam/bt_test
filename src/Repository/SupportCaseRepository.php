<?php

namespace App\Repository;

use App\Entity\SupportCase;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<SupportCase>
 *
 * @method SupportCase|null find($id, $lockMode = null, $lockVersion = null)
 * @method SupportCase|null findOneBy(array $criteria, array $orderBy = null)
 * @method SupportCase[]    findAll()
 * @method SupportCase[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SupportCaseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SupportCase::class);
    }

    public function getAmountOfCasesByStatus(?string $statusName = null): int
    {
        $builder = $this->createQueryBuilder('sc');

        if(!empty($statusName)) {
            $builder->where($builder->expr()->in('sc.status', ':statusName'))
                ->setParameter('statusName', $statusName);
        }
        return $builder->select('COUNT(sc.id)')->getQuery()->getSingleScalarResult();
    }

    public function save(SupportCase $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(SupportCase $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

}
