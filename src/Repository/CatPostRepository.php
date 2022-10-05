<?php

namespace App\Repository;

use App\Entity\CatPost;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CatPost>
 *
 * @method CatPost|null find($id, $lockMode = null, $lockVersion = null)
 * @method CatPost|null findOneBy(array $criteria, array $orderBy = null)
 * @method CatPost[]    findAll()
 * @method CatPost[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CatPostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CatPost::class);
    }

    public function add(CatPost $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CatPost $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    //Permet de compter le nombre de cat avec l'id 

    public function countCat(){
        $qb = $this->createQueryBuilder('cat')
            ->select('count(cat.id)');
        
        return $qb->getQuery()->getSingleScalarResult();
    }

//    /**
//     * @return CatPost[] Returns an array of CatPost objects
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

//    public function findOneBySomeField($value): ?CatPost
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
