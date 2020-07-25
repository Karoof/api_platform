<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ExerciseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(
 *     normalizationContext={"groups"="exercise:read"}
 * )
 * @ORM\Entity(repositoryClass=ExerciseRepository::class)
 */
class Exercise
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\OneToMany(targetEntity=Set::class, mappedBy="exercise")
     */
    private $sets;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    public function __construct()
    {
        $this->sets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Collection|Set[]
     */
    public function getSets(): Collection
    {
        return $this->sets;
    }

    public function addSet(Set $set): self
    {
        if (!$this->sets->contains($set)) {
            $this->sets[] = $set;
            $set->setExercise($this);
        }

        return $this;
    }

    public function removeSet(Set $set): self
    {
        if ($this->sets->contains($set)) {
            $this->sets->removeElement($set);
            // set the owning side to null (unless already changed)
            if ($set->getExercise() === $this) {
                $set->setExercise(null);
            }
        }

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setTextDescription(?string $description): self
    {
        $this->description = nl2br($description);

        return $this;
    }
}
