<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\HashesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\Ignore;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

#[ORM\Entity(repositoryClass: HashesRepository::class)]
class Hashes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Ignore]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $blockNumber = null;

    #[ORM\Column(length: 255)]
    private ?string $inputString = null;

    #[ORM\Column(length: 255)]
    private ?string $keyFounded = null;

    #[ORM\Column(length: 255)]
    #[Ignore]
    private ?string $generatedHash = null;

    #[ORM\Column]
    #[Ignore]
    private ?int $tries = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Context(
        context: [DateTimeNormalizer::FORMAT_KEY => 'd/m/Y H:i:s', DateTimeNormalizer::TIMEZONE_KEY => 'America/Sao_Paulo'],
    )]
    private ?\DateTimeInterface $batch = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBlockNumber(): ?int
    {
        return $this->blockNumber;
    }

    public function setBlockNumber(int $blockNumber): static
    {
        $this->blockNumber = $blockNumber;

        return $this;
    }

    public function getInputString(): ?string
    {
        return $this->inputString;
    }

    public function setInputString(string $inputString): static
    {
        $this->inputString = $inputString;

        return $this;
    }

    public function getKeyFounded(): ?string
    {
        return $this->keyFounded;
    }

    public function setKeyFounded(string $keyFounded): static
    {
        $this->keyFounded = $keyFounded;

        return $this;
    }

    public function getGeneratedHash(): ?string
    {
        return $this->generatedHash;
    }

    public function setGeneratedHash(string $generatedHash): static
    {
        $this->generatedHash = $generatedHash;

        return $this;
    }

    public function getTries(): ?int
    {
        return $this->tries;
    }

    public function setTries(int $tries): static
    {
        $this->tries = $tries;

        return $this;
    }

    public function getBatch(): ?\DateTimeInterface
    {
        return $this->batch;
    }

    public function setBatch(\DateTimeInterface $batch): static
    {
        $this->batch = $batch;

        return $this;
    }
}
