<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<User>
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    //    /**
    //     * @return User[] Returns an array of User objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
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



/**
 * Find users with minimal data for listings
 */
public function findAllForListing(): array
{
    return $this->createQueryBuilder('u')
        ->select('u.id', 'u.username', 'u.email', 'u.role', 'u.enabled')
        ->getQuery()
        ->getArrayResult();
}
    /**
     * Find user with joined rooms (when you need room data)
     */
    public function findOneWithRooms(int $id): ?User
    {
        return $this->createQueryBuilder('u')
            ->leftJoin('u.joinedRooms', 'r')
            ->addSelect('r')
            ->where('u.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }
    // src/Repository/UserRepository.php

    public function findRecentUsers(int $limit = 5): array
    {
        $users = $this->createQueryBuilder('u')
            ->select('u.id, u.username, u.email, u.role')
            ->setMaxResults($limit)
            ->orderBy('u.id', 'DESC')
            ->getQuery()
            ->getArrayResult();

        // Convert enum objects to string
        return array_map(function($u) {
            $u['role'] = $u['role']->value; // <-- converts UserRole enum to string
            return $u;
        }, $users);
    }

}
