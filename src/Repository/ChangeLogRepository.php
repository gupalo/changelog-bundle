<?php

namespace Gupalo\ChangeLogBundle\Repository;

use Gupalo\ChangeLogBundle\Entity\ChangeLog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ChangeLog>
 *
 * @method ChangeLog|null find($id, $lockMode = null, $lockVersion = null)
 * @method ChangeLog|null findOneBy(array $criteria, array $orderBy = null)
 * @method ChangeLog[]    findAll()
 * @method ChangeLog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChangeLogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ChangeLog::class);
    }
    
    public function add(ChangeLog $entity, bool $flush = false): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }
    
    public function remove(ChangeLog $entity, bool $flush = false): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function update(): void
    {
        $this->_em->flush();
    }
}
