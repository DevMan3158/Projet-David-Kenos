<?php

namespace App\Repository;

use App\Entity\Chocolaterie;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Chocolaterie>
 *
 * @method Chocolaterie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Chocolaterie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Chocolaterie[]    findAll()
 * @method Chocolaterie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChocolaterieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Chocolaterie::class);
    }

    public function add(Chocolaterie $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Chocolaterie $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function countChoco(){
        $qb = $this->createQueryBuilder('c')
            ->select('count(c.id)');
        
        return $qb->getQuery()->getSingleScalarResult();
    }

    public function findAllChoco($perPage, $firstObj){
        $query = $this->createQueryBuilder('c')
            ->setMaxResults($perPage)
            ->setFirstResult($firstObj);
        return $query->getQuery()->getResult();
    }

    public function actLieux(){
        $qb = $this->createQueryBuilder('c')
            ->select('c.lieu');
        
        return $qb->getQuery()->getResult();
    }

//    /**
//     * @return Chocolaterie[] Returns an array of Chocolaterie objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Chocolaterie
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
