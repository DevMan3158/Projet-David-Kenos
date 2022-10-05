<?php

namespace App\Repository;

use App\Entity\Actualite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Actualite>
 *
 * @method Actualite|null find($id, $lockMode = null, $lockVersion = null)
 * @method Actualite|null findOneBy(array $criteria, array $orderBy = null)
 * @method Actualite[]    findAll()
 * @method Actualite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActualiteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Actualite::class);
    }

    public function add(Actualite $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Actualite $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    // Requete qui compte les actualitées

    public function countAct(){
        $qb = $this->createQueryBuilder('a')
            ->select('count(a.id)');
        
        return $qb->getQuery()->getSingleScalarResult();
    }

    // Requête qui va chercher 3 actualitées pour l'accueil

    public function accAct(){
        $qb = $this->createQueryBuilder('a')
            ->select('a.contenu','a.crated_at')
            ->setMaxResults(3);
        
        return $qb->getQuery()->getResult();
    }

    // Reqête qui va chercher toutes les actualitées avec la pagination

    public function findAllAct($perPage, $firstObj){
        $query = $this->createQueryBuilder('a')
            ->setMaxResults($perPage)
            ->setFirstResult($firstObj);
        return $query->getQuery()->getResult();
    }



//    public function findOneBySomeField($value): ?Actualite
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
