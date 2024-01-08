<?php

namespace App\Repository;

use App\Entity\Categorie;
use App\Entity\Licencie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Model\SearchData;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;


/**
 * @extends ServiceEntityRepository<Licencie>
 *
 * @method Licencie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Licencie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Licencie[]    findAll()
 * @method Licencie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LicencieRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry,
        private PaginatorInterface $paginatorInterface
    ) {
        parent::__construct($registry, Licencie::class);
    }



    /**
     * @return Licencie[] Returns an array of Licencie objects
     */
    public function findByExampleField($value): array
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Licencie|null Returns a Licencie object
     */
    public function findOneBySomeField($value): ?Licencie
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
