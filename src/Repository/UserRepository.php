<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use DateTime;


/**
 * @extends ServiceEntityRepository<User>
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        $user->setPassword($newHashedPassword);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    public function add(User $user): void
    {
        if ($this->findOneByEmail($user->getEmail())) {
            throw new \InvalidArgumentException('El email ya está en uso.');
        }

        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    public function findOneByEmail(string $email): ?User
    {
        return $this->findOneBy(['email' => $email]);
    }

    public function findOneByToken($token): ?User{
        return $this->findOneBy(['token' => $token]);
    }

    public function tokenIsValid(User $user): bool{

        $expirationDate = new DateTime('-24 hours');
        $qb = $this->createQueryBuilder('u');
        $qb->andWhere($qb->expr()->eq('u.token', ':token'));
        $qb->andWhere($qb->expr()->gt('u.requested_token', ':expirationDate'));
        $qb->setParameter('token', $user->getToken());
        $qb->setParameter('expirationDate', $expirationDate);
        return $qb->getQuery()->getOneOrNullResult() !== null;
    }

    public function updateUser(User $user): void{

        try {
            $this->getEntityManager()->beginTransaction();
            if(!$user->isActive() && $user->isPending()){
                $user->setAsActive();
            }
            $this->getEntityManager()->persist($user);
            $this->getEntityManager()->flush();
            $this->getEntityManager()->commit();

        }catch(\Exception $e) {
           $this->getEntityManager()->rollback();
            throw $e;
        }

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
}
