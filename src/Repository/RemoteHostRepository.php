<?php

namespace App\Repository;

use App\Entity\RemoteHost;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RemoteHost>
 *
 * @method RemoteHost|null find($id, $lockMode = null, $lockVersion = null)
 * @method RemoteHost|null findOneBy(array $criteria, array $orderBy = null)
 * @method RemoteHost[]    findAll()
 * @method RemoteHost[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RemoteHostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RemoteHost::class);
    }

    public function getHostByName($name): ?RemoteHost
    {
        $qb = $this->createQueryBuilder('rh')
            ->select()
            ->andWhere('rh.name = :name')
            ->setParameter(':name', $name)
        ;
        $query = $qb->getQuery();
        return $query->getOneOrNullResult();
    }

    public function getHostByNameAndToken($name, $token): ?RemoteHost
    {
        $qb = $this->createQueryBuilder('rh')
            ->select()
            ->andWhere('rh.name = :name')
            ->setParameter(':name', $name)
            ->andWhere('rh.token = :token')
            ->setParameter('token', $token)
        ;
        $query = $qb->getQuery();
        return $query->getOneOrNullResult();
    }

    public function getAllRemoteHosts(): array|null
    {
        $qb = $this->createQueryBuilder('rh')
            ->select('rh.id', 'rh.intervalStart', 'rh.intervalEnd')
        ;
        $query = $qb->getQuery();
        return $query->getResult();
    }

//    /**
//     * @return RemoteHost[] Returns an array of RemoteHost objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?RemoteHost
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
