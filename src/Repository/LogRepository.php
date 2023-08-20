<?php

namespace App\Repository;

use App\Entity\Log;
use App\Entity\RemoteHost;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Log>
 *
 * @method Log|null find($id, $lockMode = null, $lockVersion = null)
 * @method Log|null findOneBy(array $criteria, array $orderBy = null)
 * @method Log[]    findAll()
 * @method Log[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Log::class);
    }

    public function selectIntLogowZError($ilosc): array
    {
        $qb = $this->createQueryBuilder('l')
            ->select()
            ->andWhere('l.status = :status')
            ->setParameter(':status',1)
            ->setFirstResult(0)
            ->setMaxResults($ilosc)
            ->orderBy('l.timeStamp', 'DESC')
            ;
        $query = $qb->getQuery();
        return $query->getResult();
    }


    public function selectIstatniLogRemoteHosta($remoteHost): ?Log
    {
        $qb = $this->createQueryBuilder('l')
            ->select()
            ->orderBy('l.timeStamp', 'DESC')
            ->andWhere('l.remoteHost = :remote_host')
            ->setParameter('remote_host', $remoteHost)
            ->setMaxResults(1)
            ;
        $query = $qb->getQuery();
        return $query->getOneOrNullResult();
    }

    public function getDisiejszeLogiZError(): array|null
    {
        $today = new \DateTime("today");
        $qb = $this->createQueryBuilder('l')
            ->select()
            ->andWhere('l.status = :status')
            ->setParameter(':status', 1)
            ->andWhere('l.timeStamp > :date')
            ->setParameter(':date', $today)
            ;
        $query = $qb->getQuery();
        return $query->getResult();
    }
//    /**
//     * @return Log[] Returns an array of Log objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('l.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Log
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
