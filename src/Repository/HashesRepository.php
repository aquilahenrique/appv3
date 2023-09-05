<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Hashes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Hashes>
 *
 * @method Hashes|null find($id, $lockMode = null, $lockVersion = null)
 * @method Hashes|null findOneBy(array $criteria, array $orderBy = null)
 * @method Hashes[]    findAll()
 * @method Hashes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HashesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Hashes::class);
    }

    public function storeBatch(array $hashes): void
    {

        foreach ($hashes as $hash) {
            $entity = (new Hashes())
                ->setGeneratedHash($hash['hash'])
                ->setBatch($hash['batch'])
                ->setTries($hash['tries'])
                ->setBlockNumber($hash['block_number'])
                ->setInputString($hash['word'])
                ->setKeyFounded($hash['key']);

            $this->getEntityManager()->persist($entity);
        }

        $this->getEntityManager()->flush();
    }

    public function search(array $criteria): QueryBuilder
    {
        $qb = $this->createQueryBuilder('h')
            ->orderBy('h.id', 'ASC');

        if (isset($criteria['tries']) && $criteria['tries']) {
            $qb->andWhere('h.tries < :tries');
            $qb->setParameter('tries', (int) $criteria['tries']);
        }

        return $qb;
    }
}
