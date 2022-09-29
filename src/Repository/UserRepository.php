<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function add(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);

        $this->add($user, true);
    }

    public function findAllWithChoco($perPage, $firstObj){
        $query = $this->createQueryBuilder('u')
            ->setMaxResults($perPage)
            ->setFirstResult($firstObj);
        return $query->getQuery()->getResult();
    }

    public function countUser(){
        $qb = $this->createQueryBuilder('u')
            ->select('count(u.id)');
        
        return $qb->getQuery()->getSingleScalarResult();
    }

/*    public function findAllWithChoco()
{
    $rawSql = "SELECT * FROM user INNER JOIN chocolaterie on user.chocolaterie_id = chocolaterie.id LIMIT 0,5";

    $stmt = $this->getEntityManager()->getConnection()->prepare($rawSql);
    $stmt->executeQuery([]);

    $stmt->fetchAllAssociative();
}*/

/*public function findAllWithChoco()
    {

    $query = $this->createQuery(
        "SELECT *
         FROM user
         INNER JOIN chocolaterie
         ON user.chocolaterie_id = chocolaterie.id
         LIMIT 0,5");
 
    // returns an array of Product objects
    return $query->getQuery()
                ->getResult();
         
    }*/

//    /**
//     * @return User[] Returns an array of User objects
//     */
//
//    public function findBycommentaire($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u. = :val')
//          ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }


    


//    public function findOneBySomeField($value): ?User
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
