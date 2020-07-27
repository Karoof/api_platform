<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ProgressionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(
 *     collectionOperations={"get", "post"},
 *     itemOperations={
 *         "get"={"path"="/api/getset/{id}"}, 
 *         "put"
 *     }
 * )
 * @ORM\Entity(repositoryClass=setRepository::class)
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
     */
    private $number;

    /**
     * @ORM\ManyToOne(targetEntity=Exercise::class, inversedBy="sets")
     */
    private $exercise;

    /**
     * @ORM\OneToMany(targetEntity=Rep::class, mappedBy="progression")
     */
    private $reps;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    public function __construct()
    {
        $this->reps = new ArrayCollection();
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

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
