<?php

namespace App\Repository;

use App\Entity\Client;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

/**
 * @method Client|null findOneBy(array $criteria, array $orderBy = null)
 * @method Client|null find($id, $lockMode = null, $lockVersion = null)
 * @method Client[]    findAll()
 * @method Client[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClientRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Client::class);
    }
    
   
    public function findByUserId($userId, $lockMode = null, $lockVersion = null)
    {
        $client = $this->_findByUserId($userId);
        /**
        if (!is_null($client)) {
            $qb = $this->_em->createQueryBuilder();
           
            $qb->select( 'u')
                ->from('User', 'u')
                ->where($qb->expr()->eq('u.id', '?1'))
                ->setParameter(1, $userId);
            $query = $qb->getQuery();
            
            $user = $query->getSingleResult();
            if (!is_null($user)) {
                $client->setUser($user);
            } else {
                throw new UsernameNotFoundException('Client exists, but user account is not found');
            }
            
        }
        **/
        return $client;
    }
    
    private function _findByUserId($userId) {
        $qb = $this->_em->createQueryBuilder();

        $qb->select( 'c')
            ->from(Client::class, 'c')
            ->join('c.user', 'u')
            ->where($qb->expr()->eq('u.id', '?1'))
            ->setParameter(1, $userId);
        $query = $qb->getQuery();
        return $query->getSingleResult();
    }
}
