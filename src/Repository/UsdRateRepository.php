<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\UsdRate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * class RateRepository
 * @extends ServiceEntityRepository<UsdRate>
 * @method UsdRate|null find($id, $lockMode = null, $lockVersion = null)
 * @method UsdRate|null findOneBy(array $criteria, array $orderBy = null)
 * @method UsdRate[]    findAll()
 * @method UsdRate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @package App\Repository
 */
class UsdRateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UsdRate::class);
    }

    public function getByCurrency(string $currency): UsdRate
    {
        return $this->findOneBy(['currency' => $currency]);
    }

    public function getAllCurrencies(): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT DISTINCT u.currency FROM App\Entity\UsdRate u'
        );

        $currencies = array_map(static fn ($i) => $i['currency'], $query->getResult());
        return array_combine(array_values($currencies), $currencies);
    }

    public function storeRate(string $currency, float $rate)
    {
        $em = $this->getEntityManager();
        $usdRate = $this->findOneBy(['currency' => $currency]);

        if (!$usdRate) {
            $usdRate = new UsdRate();
            $usdRate->setCurrency($currency);
        }

        $usdRate->setRate($rate);
        $usdRate->setTimestamp(new \DateTime());

        $em->persist($usdRate);
        $em->flush();
    }
}
