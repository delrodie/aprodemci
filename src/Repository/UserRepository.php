<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

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
	private $passwordHasher;
	private $security;
	
	public function __construct(ManagerRegistry $registry, UserPasswordHasherInterface $passwordHasher, Security $security)
    {
        parent::__construct($registry, User::class);
	    $this->passwordHasher = $passwordHasher;
	    $this->security = $security;
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
	
	/**
	 * @param UserPasswordHasherInterface $passwordHasher
	 * @return bool
	 */
	public function addUser(): bool
	{
		$userVerif = $this->findOneBy(['email'=>'delrodieamoikon@gmail.com']);
		if (!$userVerif){
			$user =  new User();
			$user->setEmail('delrodieamoikon@gmail.com');
			$user->setRoles(['ROLE_SUPER_ADMIN']);
			$user->setPassword($this->passwordHasher->hashPassword($user, 'delroy@2020'));
			
			$this->add($user, true);
			
			return true;
		}
		
		return false;
	}
	
	/**
	 * @return bool
	 */
	public function connexion(): bool
	{
		$user = $this->findOneBy(['email' => $this->security->getUser()->getUserIdentifier()]);
		$nombre_connexion = $user->getConnexion();
		$user->setConnexion($nombre_connexion + 1);
		$user->setLastConnectedAt(new \DateTime());
		
		$this->add($user, true);
		
		return true;
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
