<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ExchangeRateRepository;
use Doctrine\ORM\Mapping as ORM;
use DateTimeInterface;

/**
 * Class ExchangeRate
 * @package App\Entity
 */
#[ORM\Entity(repositoryClass: ExchangeRateRepository::class)]
#[ORM\UniqueConstraint(name: "exchange_rate_unique", columns: ["source", "target", "provider"])]
class ExchangeRate
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 3)]
    private string $source;

    #[ORM\Column(type: 'string', length: 3)]
    private string $target;

    #[ORM\Column(type: 'decimal', precision: 16, scale: 8)]
    private float $rate;

    #[ORM\Column(type: 'string', length: 255)]
    private string $provider;

    #[ORM\Column(type: 'datetime')]
    private DateTimeInterface $timestamp;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSource(): ?string
    {
        return $this->source;
    }

    public function setSource(string $source): static
    {
        $this->source = $source;

        return $this;
    }

    public function getTarget(): ?string
    {
        return $this->target;
    }

    public function setTarget(string $target): static
    {
        $this->target = $target;

        return $this;
    }

    public function getRate(): ?float
    {
        return $this->rate;
    }

    public function setRate(float $rate): static
    {
        $this->rate = $rate;

        return $this;
    }

    public function getProvider(): ?string
    {
        return $this->provider;
    }

    public function setProvider(string $provider): static
    {
        $this->provider = $provider;

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
