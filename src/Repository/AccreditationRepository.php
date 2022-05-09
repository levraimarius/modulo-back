<?php

namespace App\Repository;

use App\Entity\Accreditation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Accreditation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Accreditation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Accreditation[]    findAll()
 * @method Accreditation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AccreditationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Accreditation::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Accreditation $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Accreditation $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return Accreditation[] Returns an array of Accreditation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Accreditation
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
