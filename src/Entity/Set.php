<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\SetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     itemOperations={
 *          "get"={
 *              "normalization_context"={"groups"={"set:read", "set:item:get"}},
 *          },
 *          "put"
 *     },
 *     normalizationContext={"groups"={"set:read"}},
 *     denormalizationContext={"groups"={"set:write"}},
 *     collectionOperations={"get", "post"},
 * )
 * @ORM\Entity(repositoryClass=SetRepository::class)
 * @ORM\Table(name="`set`")
 */
class Set
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"set:read", "set:write", "exercise:read", "exercise:write"})
     * @Assert\NotBlank()
     */
    private $number;

    /**
     * @ORM\ManyToOne(targetEntity=Exercise::class, inversedBy="sets")
     * @Groups({"set:read", "set:write"})
     * @Assert\Valid()
     */
    private $exercise;

    /**
     * @ORM\OneToMany(targetEntity=Rep::class, mappedBy="progression")
     * @Groups({"set:read","exercise:read"})
     */
    private $reps;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    public function __construct()
    {
        $this->reps = new ArrayCollection();
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

    public function getExercise(): ?Exercise
    {
        return $this->exercise;
    }

    public function setExercise(?Exercise $exercise): self
    {
        $this->exercise = $exercise;

        return $this;
    }

    /**
     * @return Collection|Rep[]
     */
    public function getReps(): Collection
    {
        return $this->reps;
    }

    public function addRep(Rep $rep): self
    {
        if (!$this->reps->contains($rep)) {
            $this->reps[] = $rep;
            $rep->setProgression($this);
        }

        return $this;
    }

    public function removeRep(Rep $rep): self
    {
        if ($this->reps->contains($rep)) {
            $this->reps->removeElement($rep);
            // set the owning side to null (unless already changed)
            if ($rep->getProgression() === $this) {
                $rep->setProgression(null);
            }
        }

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }
}
