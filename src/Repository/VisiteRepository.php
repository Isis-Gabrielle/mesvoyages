<?php

namespace App\Repository;

use App\Entity\Visite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Visite>
 */
class VisiteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Visite::class);
    }

  /**
 * 
 * @param type $champ
 * @param type $ordre
 * @return visite[]
 */
    public function findAllOrderBy($champ, $ordre): array{
        return $this->createQueryBuilder('v')
                ->orderBy('v.'.$champ, $ordre)
                ->getQuery()
                ->getResult();
    }
    
    public function findLastTwo(): array{
        return $this->createQueryBuilder('v')
                ->orderBy('v.datecreation', 'DESC')
                ->setMaxResults(2)
                ->getQuery()
                ->getResult();
    }
    
    /**
     * 
     * @param type $champ
     * @param type $valeur
     * @return visite[]
     */
     public function findByEqualValue($champ, $valeur): array{
        if ($valeur==""){
         return $this->createQueryBuilder('v')
                ->orderBy('v.'.$champ, 'ASC')
                ->getQuery()
                ->getResult();
        }
        else{
            return $this->createQueryBuilder('v')
                    ->where('v.'.$champ.'=:valeur')
                    ->setParameter('valeur', $valeur)
                ->orderBy('v.datecreation', 'DESC')
                ->getQuery()
                ->getResult();
        }
    }
    /**
     * 
     * @param Visite $visite
     * @return void
     */
    public function remove(Visite $visite): void{
        $this->getEntityManager()->remove($visite);
        $this->getEntityManager()->flush();
    }
    /**
     * 
     * @param Visite $visite
     * @return void
     */
    public function add(Visite $visite): void{
        $this->getEntityManager()->persist($visite);
        $this->getEntityManager()->flush();
    }
}
