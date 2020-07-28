<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\RangeFilter;
use App\Repository\RepRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"rep:read"}},
 *     denormalizationContext={"groups"={"rep:write"}},
 * )
 * @ORM\Entity(repositoryClass=RepRepository::class)
 * @ApiFilter(RangeFilter::class, properties={"number"})
 */
class Rep
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"rep:read", "rep:write", "exercise:read"})
     */
    private $number;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"rep:read", "rep:write"})
     */
    private $weight;

    /**
     * @ORM\ManyToOne(targetEntity=Set::class, inversedBy="reps")
     * @Groups({"rep:read", "rep:write"})
     */
    private $progression;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getWeight(): ?int
    {
        return $this->weight;
    }

    public function setWeight(int $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    public function getProgression(): ?Set
    {
        return $this->progression;
    }

    public function setProgression(?Set $progression): self
    {
        $this->progression = $progression;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }
}
