<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\UsdRateRepository;
use Doctrine\ORM\Mapping as ORM;
use DateTimeInterface;

/**
 * Class UsdRate
 * @package App\Entity
 */
#[ORM\Entity(repositoryClass: UsdRateRepository::class)]
#[ORM\UniqueConstraint(name: "currency_unique", columns: ["currency"])]
class UsdRate
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 3)]
    private string $currency;

    #[ORM\Column(type: 'decimal', precision: 16, scale: 8)]
    private string $rate;

    #[ORM\Column(type: 'datetime')]
    private DateTimeInterface $timestamp;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): static
    {
        $this->currency = $currency;

        return $this;
    }

    public function getRate(): ?string
    {
        return $this->rate;
    }

    public function setRate(string $rate): static
    {
        $this->rate = $rate;

        return $this;
    }

    public function getTimestamp(): ?\DateTimeInterface
    {
        return $this->timestamp;
    }

    public function setTimestamp(\DateTimeInterface $timestamp): static
    {
        $this->timestamp = $timestamp;

        return $this;
    }
}
