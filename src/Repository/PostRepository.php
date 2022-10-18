<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Post>
 *
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    public function add(Post $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Post $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

     
    // Requete qui compte le nombre de posts OU compte le nombre de posts en fonction des filtres 

    public function countPost($filters = null){
        $qb = $this->createQueryBuilder('p')
            ->select('count(p)');

        // On compte les postes par filtres
        if($filters != null){
            $qb->where('p.cat_post IN (:cats)')
            ->setParameter(':cats', array_values($filters));
        };
        
        return $qb->getQuery()->getSingleScalarResult();
    }



    // Requete qui va chercher les posts avec le user si besoin

    public function postPaginateUser($perPage, $firstObj, $user = null){
        $query = $this->createQueryBuilder('p');


        //On recherche les posts par user si besoin

            if($user != null){

                $query->where('p.user = :user')
                ->setParameter(':user', $user);

            }

            $query->setMaxResults($perPage)
            ->setFirstResult($firstObj)
            ->orderBy('p.id', 'DESC');

        return $query->getQuery()->getResult();
    }



        // Requete qui va chercher les posts avec la pagination + les filtres

        public function postPaginateFilters($perPage, $firstObj, $filters = null){
            $query = $this->createQueryBuilder('p');

        //On recherche les posts par filtres si besoin
            
        if($filters != null){

            $query->where('p.cat_post IN (:cats)')
            ->setParameter(':cats', array_values($filters));
        }

            $query->setMaxResults($perPage)
                ->setFirstResult($firstObj)
                ->orderBy('p.id', 'DESC');
            return $query->getQuery()->getResult();
        }





//    /**
//     * @return Post[] Returns an array of Post objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Post
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}