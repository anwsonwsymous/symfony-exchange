<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\ExchangeRate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * class ExchangeRateRepository
 * @extends ServiceEntityRepository<ExchangeRate>
 * @method ExchangeRate|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExchangeRate|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExchangeRate[]    findAll()
 * @method ExchangeRate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @package App\Repository
 */
class ExchangeRateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExchangeRate::class);
    }

    public function getByTarget(string $target): array
    {
        return $this->createQueryBuilder('er')
            ->where('er.target = :target')
            ->setParameter('target', $target)
            ->getQuery()
            ->getResult();
    }

    public function getByProvider(string $provider): array
    {
        return $this->createQueryBuilder('er')
            ->where('er.provider = :provider')
            ->setParameter('provider', $provider)
            ->getQuery()
            ->getResult();
    }

    public function storeExchangeRate(string $source, string $target, float $rate, string $provider)
    {
        $em = $this->getEntityManager();
        $exchangeRate = $this->findOneBy(['source' => $source, 'target' => $target, 'provider' => $provider]);

        if (!$exchangeRate) {
            $exchangeRate = new ExchangeRate();
            $exchangeRate->setSource($source);
            $exchangeRate->setTarget($target);
            $exchangeRate->setProvider($provider);
        }

        $exchangeRate->setRate($rate);
        $exchangeRate->setTimestamp(new \DateTime());

        $em->persist($exchangeRate);
        $em->flush();
    }
}
