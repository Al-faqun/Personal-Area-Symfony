<?php

namespace App\Repository;

use App\Entity\Manager;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Manager|null find($id, $lockMode = null, $lockVersion = null)
 * @method Manager|null findOneBy(array $criteria, array $orderBy = null)
 * @method Manager[]    findAll()
 * @method Manager[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ManagerRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Manager::class);
    }
    
    public function findByUserId($userId, $lockMode = null, $lockVersion = null)
    {
        $client = $this->_findByUserId($userId);

        return $client;
    }
    
    private function _findByUserId($userId) {
        $qb = $this->_em->createQueryBuilder();
        
        $qb->select( 'm')
            ->from(Manager::class, 'm')
            ->join('m.user', 'u')
            ->where($qb->expr()->eq('u.id', '?1'))
            ->setParameter(1, $userId);
        $query = $qb->getQuery();
        return $query->getSingleResult();
    }
}
